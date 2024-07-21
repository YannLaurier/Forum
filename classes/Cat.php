<?php

class Cat {
    private $title;
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }

    public static function deleteCat(PDO $bdd, $catId)
    {
        try {
            $bdd->beginTransaction();

            $sql = $bdd->prepare('DELETE FROM cat WHERE id = :dyingcat');
            $sql->bindParam(':dyingcat', $catId);
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

    public static function bringCats(PDO $bdd)
    {
        try {
            $sql = 'SELECT * FROM cat';
            $cats = $bdd->query($sql);
            return $cats->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public static function addCat(PDO $bdd, $catname = "")
    {
        try {
            $bdd->beginTransaction();

            $sql = $bdd->prepare('INSERT INTO cat(title) VALUES (:catname)');
            $sql->bindParam(':catname', $catname);
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