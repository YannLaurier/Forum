<?php

class bdd
{
    private $bdd;

    public function connectBDD()
    {
        try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
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
        if($row === 0) {
            $result = false;
        } else {
            $result = true;
        };
        return $result;
    }

    public function compareEmail($param = ""): bool
    {
        $sql = $this->bdd->prepare('SELECT * FROM user WHERE email = :email');
        $sql->bindParam(':email', $param);
        $sql->execute();
        $row = $sql->rowCount();
        if($row === 0) {
            $result = false;
        } else {
            $result = true;
        };
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

    public function bringCats(){
        $sql = 'SELECT * FROM cat';
        $cats = $this->bdd->query($sql);
        return $cats->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bringSubCats(){
        $sql = 'SELECT * FROM subcat';
        $subcats = $this->bdd->query($sql);
        return $subcats->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCat($param =""){
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

    public function addSubCat($param = []){
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

    public function deleteCat($param){
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

    public function deleteSubCat($param){
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
}
