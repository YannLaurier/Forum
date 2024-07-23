<?php
class Answer {
    private $content;
    private $author;
    private $post;

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setPost($post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }

    public static function countAns(PDO $bdd, $id)
    {
        try {
            $sql =  $bdd->prepare('SELECT FK_post_id, COUNT(*)
                    FROM `answers`
                    WHERE FK_post_id = :id
                    GROUP BY Fk_post_id');
            $sql->bindParam(':id', $id);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public static function bringAns(PDO $bdd, $postId)
    {
        try {
            $sql = $bdd->prepare('SELECT Pseudo, profilePicType, profilePicData, user.id, content, time, FK_post_id
                                FROM user
                                LEFT JOIN answers ON user.id = answers.FK_author_id
                                WHERE answers.FK_post_id = :postId
                                ORDER BY time ASC');
            $sql->bindParam(':postId', $postId);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public static function addAns(PDO $bdd, Answer $ans)
    {
        try {
            $bdd->beginTransaction();
            $content = $ans->getContent();
            $author = $ans->getAuthor();
            $post = $ans->getPost();

            $sql = $bdd->prepare('INSERT INTO answers(content, FK_author_id, FK_post_id) VALUES (:content, :author, :post)');
            $sql->bindParam(':content', $content);
            $sql->bindParam(':author', $author);
            $sql->bindParam(':post', $post);
            $sql->execute();
            $bdd->commit();
        } catch (\Throwable $th) {
            $bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public static function bringThatGuysAns(PDO $bdd, int $userId)
    {
        try {
            $sql = $bdd->prepare('SELECT *
                                  FROM answers
                                  WHERE FK_author_id = :id
                                  ORDER BY time ASC
                                  LIMIT 5');
            $sql->bindParam(':id', $userId);
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