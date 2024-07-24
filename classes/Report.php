<?php

class Report
{
    private $reporterId;
    private $reason;
    private $details;
    private $postId;
    private $answerId;
    private $treated;

    public function setReporterId($reporterId)
    {
        $this->reporterId = $reporterId;
    }

    public function getReporterId()
    {
        return $this->reporterId;
    }
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setDetails($details)
    {
        $this->details = $details;
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    public function getPostId()
    {
        return $this->postId;
    }
    public function setAnswerId($answerId)
    {
        $this->answerId = $answerId;
    }

    public function getAnswerId()
    {
        return $this->answerId;
    }

    public static function addReport(PDO $bdd, Report $report)
    {
        try {
            $bdd->beginTransaction();
            $reporterId = $report->getReporterId();
            $reason = $report->getReason();
            $postId = $report->getPostId();
            $answerId = $report->getAnswerId();
            $details = $report->getDetails();

            if (!empty($answerId)) {
                $sql = $bdd->prepare('INSERT INTO report(FK_id_reporter, reason, details, FK_id_post, FK_id_answer) VALUES (:reporterId, :reason, :details, :postId, :answerId)');
                $sql->bindParam(':reporterId', $reporterId);
                $sql->bindParam(':reason', $reason);
                $sql->bindParam(':details', $details);
                $sql->bindParam(':postId', $postId);
                $sql->bindParam(':answerId', $answerId);
                $sql->execute();
            } elseif (!empty($postId)) {
                $sql = $bdd->prepare('INSERT INTO report(FK_id_reporter, reason, details, FK_id_post) VALUES (:reporterId, :reason, :details, :postId)');
                $sql->bindParam(':reporterId', $reporterId);
                $sql->bindParam(':reason', $reason);
                $sql->bindParam(':details', $details);
                $sql->bindParam(':postId', $postId);
                $sql->execute();
            }

            $bdd->commit();

        } catch (\Throwable $th) {
            $bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public static function bringAllReports(PDO $bdd, $firstEntry, $reportPerPage)
    {
        try {
            $sql = $bdd->prepare("SELECT report.id AS reportId, FK_id_reporter, reason, details, FK_id_post, FK_id_answer, treated, posts.id AS postId, posts.FK_author_id AS postAuthor, posts.title AS postTitle, posts.content AS postContent, answers.id AS answerID, answers.FK_author_id AS answerAuthor, answers.FK_post_id AS postFromAnswer, answers.content AS answerContent, user.id as reporterId, user.Pseudo as reporterPseudo
                        FROM report
                        LEFT JOIN posts ON report.FK_id_post = posts.id
                        LEFT JOIN answers ON report.FK_id_answer = answers.id
                        LEFT JOIN user ON report.FK_id_reporter = user.id
                        WHERE treated = 0
                        ORDER BY report.id ASC
                        LIMIT $firstEntry, $reportPerPage;");
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);

        }
    }

    public static function deleteReport(PDO $bdd, $reportId)
    {
        try {
            $sql = $bdd->prepare('UPDATE report
                                  SET treated = 1
                                  WHERE id = :reportId');
            $sql->bindParam(':reportId', $reportId);
            $sql->execute();
            $bdd->commit();

        } catch (\Throwable $th) {
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);

        }
    }

    public static function countReports(PDO $bdd, $userId = -1)
    {
        if ($userId === -1) {
            try {
                $sql = 'SELECT FK_id_reporter, COUNT(*) FROM `report`';
                $nbReports = $bdd->query($sql);
                return $nbReports->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Throwable $th) {
                $error = fopen("error.txt", "w");
                $txt = $th->getMessage();
                fwrite($error, $txt);
                fclose($error);
            }
        }else{
        try {
            $sql =  $bdd->prepare('SELECT FK_id_reporter, COUNT(*)
                    FROM `report`
                    WHERE FK_id_reporter = :userId');
            $sql->bindParam(':userId', $userId);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }
    }
}