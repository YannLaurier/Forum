<?php

class Post
{
    private $title;
    private $content;
    private $author;
    private $subcat;

    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
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

    public function setSubCat($subcat)
    {
        $this->subcat = $subcat;
    }

    public function getSubCat()
    {
        return $this->subcat;
    }

    public static function bringPosts(PDO $bdd)
    {
        try {
            $sql = 'SELECT * FROM posts';
            $allPosts = $bdd->query($sql);
            return $allPosts->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public static function addPost(PDO $bdd, post $post)
    {
        try {
            $bdd->beginTransaction();
            $author = $post->getAuthor();
            $subcat = $post->getSubCat();
            $title = $post->getTitle();
            $content = $post->getContent();

            $sql = $bdd->prepare('INSERT INTO posts(FK_author_id, FK_category_id, title, content) VALUES (:author, :subcat, :title, :content)');
            $sql->bindParam(':author', $author);
            $sql->bindParam(':subcat', $subcat);
            $sql->bindParam(':title', $title);
            $sql->bindParam(':content', $content);
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

    public static function bringThatGuysPosts(PDO $bdd, int $userId)
    {
        try {
            $sql = $bdd->prepare('SELECT *
                                  FROM posts
                                  WHERE FK_author_id = :id
                                  ORDER BY publication_date DESC
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

    public static function bringOnePost(PDO $bdd, int $postId)
    {
        try {
            $sql = $bdd->prepare('SELECT user.id AS userId, user.Pseudo, user.`status`, user.profilePicType, user.profilePicData, posts.id AS postId, posts.FK_author_id, posts.FK_category_id, posts.title AS postTitle, posts.content, posts.publication_date, subcat.id AS subCatId, subcat.title AS subCatTitle, subcat.FK_mother_cat AS catId
                                  FROM posts
                                  LEFT JOIN user ON posts.FK_author_id = user.id
                                  LEFT JOIN subcat ON subcat.id = posts.FK_category_id
                                  WHERE posts.id = :postId;');
            $sql->bindParam(':postId', $postId);
            $sql->execute();

            return $sql->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public static function deletePost($bdd, $postId)
    {
        try {
            $bdd->beginTransaction();

            $sql = $bdd->prepare('DELETE FROM posts
                                  WHERE id = :postId');
            $sql->bindParam(':postId', $postId);
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

    public static function editPost(PDO $bdd, $title, $content, $id)
    {
        try {
            $bdd->beginTransaction();

            $sql = $bdd->prepare("UPDATE posts
            SET title = :title,  content = :content
            WHERE id = :id");
            $sql->bindParam(':title', $title);
            $sql->bindParam(':content', $content);
            $sql->bindParam(':id', $id);
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
}