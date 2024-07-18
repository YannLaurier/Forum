<?php

class bdd
{
    private $bdd;

    public function connectBDD()
    {
        try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=forum', 'root', 'root');
            return $this->bdd;

        } catch (PDOException $e) {
            $error = fopen('error.log', 'w');
            $txt = $e . '\n';
            fwrite($error, $txt);
            throw new Exception('Connexion échouée');
        }
    }

    public function disconnectBDD()
    {
        $this->bdd = null;
    }

    public function comparePseudo($param = ""): bool
    {
        $sql = $this->bdd->prepare('SELECT * FROM user WHERE pseudo = :pseudo');
        $sql->bindParam(':pseudo', $param);
        $sql->execute();
        $row = $sql->rowCount();
        if ($row === 0) {
            $result = false;
        } else {
            $result = true;
        }
        ;
        return $result;
    }

    public function compareEmail($param = ""): bool
    {
        $sql = $this->bdd->prepare('SELECT * FROM user WHERE email = :email');
        $sql->bindParam(':email', $param);
        $sql->execute();
        $row = $sql->rowCount();
        if ($row === 0) {
            $result = false;
        } else {
            $result = true;
        }
        ;
        return $result;
    }

    public function addUser(user $user)
    {
        try {
            $this->bdd->beginTransaction();
            $pseudo = $user->getPseudo();
            $pass = $user->getPass();
            $email = $user->getEmail();
            $status = "user";

            $sql = $this->bdd->prepare('INSERT INTO user(Pseudo, email, Pass, status) VALUES (:pseudo, :email, :pass, :status)');
            $sql->bindParam(':pseudo', $pseudo);
            $sql->bindParam(':pass', $pass);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':status', $status);
            $sql->execute();
            $this->bdd->commit();
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function connectUser($pseudo)
    {
        try {
            $sql = $this->bdd->prepare("SELECT * FROM user WHERE Pseudo = :pseudo");
            $sql->bindParam(':pseudo', $pseudo);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function bringUsers(){
        try {
            $sql = 'SELECT * FROM user';
            $users = $this->bdd->query($sql);
            return $users->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function bringCats()
    {
        try {
            $sql = 'SELECT * FROM cat';
            $cats = $this->bdd->query($sql);
            return $cats->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function bringSubCats()
    {
        try {
            $sql = 'SELECT * FROM subcat';
            $subcats = $this->bdd->query($sql);
            return $subcats->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function addCat($param = "")
    {
        try {
            $this->bdd->beginTransaction();
            $catname = $param;

            $sql = $this->bdd->prepare('INSERT INTO cat(title) VALUES (:catname)');
            $sql->bindParam(':catname', $catname);
            $sql->execute();
            $this->bdd->commit();
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function addSubCat($param = [])
    {
        try {
            $this->bdd->beginTransaction();
            $NewSubCat = $param["NewSubCat"];
            $motherCat = $param["MotherCat"];

            $sql = $this->bdd->prepare('INSERT INTO subcat(title, FK_mother_cat) VALUES (:NewSubCat, :motherCat)');
            $sql->bindParam(':NewSubCat', $NewSubCat);
            $sql->bindParam(':motherCat', $motherCat);
            $sql->execute();
            $this->bdd->commit();
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function deleteCat($param)
    {
        try {
            $this->bdd->beginTransaction();
            $DyingCat = $param;

            $sql2 = $this->bdd->prepare('DELETE FROM subcat WHERE FK_mother_cat = :dyingcat');
            $sql2->bindParam(':dyingcat', $DyingCat);
            $sql2->execute();
            $sql = $this->bdd->prepare('DELETE FROM cat WHERE id = :dyingcat');
            $sql->bindParam(':dyingcat', $DyingCat);
            $sql->execute();
            $this->bdd->commit();
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function deleteSubCat($param)
    {
        try {
            $this->bdd->beginTransaction();
            $DyingSubCat = $param;

            $sql = $this->bdd->prepare('DELETE FROM subcat WHERE id = :dyingsubcat');
            $sql->bindParam(':dyingsubcat', $DyingSubCat);
            $sql->execute();
            $this->bdd->commit();
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    // public function updateCat($param){
    //     try{
    //         $this->bdd->beginTransaction();
    //         $growingCat = $param;

    //         $sql = $this->bdd->prepare('UPDATE cat SET title = :growingCat')

    //     } catch (\Throwable $th) {
    //         $this->bdd->rollBack();
    //         $error = fopen("error.txt", "w");
    //         $txt = $th->getMessage();
    //         fwrite($error, $txt);
    //         fclose($error);
    //     }
    // }

    public function bringMods()
    {
        try {
            $sql = 'SELECT * FROM user WHERE status = "modo"';
            $allMods = $this->bdd->query($sql);
            return $allMods->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function addMod($param){
        try{
            $this->bdd->beginTransaction();
            $newMod = $param;

            $sql = $this->bdd->prepare('UPDATE user SET status = "modo" WHERE Pseudo = :newMod');
            $sql->bindParam(':newMod', $newMod);
            $sql->execute();
            $this->bdd->commit();
        }catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function deleteMod($param){
        try{
            $this->bdd->beginTransaction();
            $fallenMod = $param;

            $sql = $this->bdd->prepare('UPDATE user SET status = "user" WHERE Pseudo = :fallenMod');
            $sql->bindParam(':fallenMod', $fallenMod);
            $sql->execute();
            
            $this->bdd->commit();
        }catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function bringPosts(){
        try {
            $sql = 'SELECT * FROM posts';
            $allPosts = $this->bdd->query($sql);
            return $allPosts->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function addPost(post $post)
    {
        try {
            $this->bdd->beginTransaction();
            $author = $post->getAuthor();
            $subcat = $post->getSubCat();
            $title = $post->getTitle();
            $content = $post->getContent();

            $sql = $this->bdd->prepare('INSERT INTO posts(FK_author_id, FK_category_id, title, content) VALUES (:author, :subcat, :title, :content)');
            $sql->bindParam(':author', $author);
            $sql->bindParam(':subcat', $subcat);
            $sql->bindParam(':title', $title);
            $sql->bindParam(':content', $content);
            $sql->execute();
            $this->bdd->commit();
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function countAns(){
        try {
            $sql = 'SELECT FK_post_id, COUNT(*) FROM `answers` GROUP BY Fk_post_id';
            $numAns = $this->bdd->query($sql);
            return $numAns->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function bringAns($param){
        try {
            $num = $param;

            $sql = $this->bdd->prepare('SELECT * FROM `answers` WHERE Fk_post_id = :num');
            $sql->bindParam(':num', $num);
            $allAns = $this->bdd->query($sql);
            return $allAns->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public function addAns(answer $ans)
    {
        try {
            $this->bdd->beginTransaction();
            $content = $ans->getContent();
            $author = $ans->getAuthor();
            $post = $ans->getPost();

            $sql = $this->bdd->prepare('INSERT INTO answers(content, FK_author_id, FK_post_id) VALUES (:content, :author, :post)');
            $sql->bindParam(':content', $content);
            $sql->bindParam(':author', $author);
            $sql->bindParam(':post', $post);
            $sql->execute();
            $this->bdd->commit();
        } catch (\Throwable $th) {
            $this->bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }
}
