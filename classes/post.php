<?php

class post
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
}