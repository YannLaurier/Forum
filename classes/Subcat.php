<?php

class Subcat {
    private $id;
    private $cat_id;
    private $title;

    public function setCat_id($cat_id)
    {
        $this->cat_id = $cat_id;
    }

    public function getCat_id()
    {
        return $this->cat_id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public static function bringSubCats(PDO $bdd, $catId = -1)
    {
        if ($catId === -1) {
            try {
                $sql = 'SELECT * FROM subcat';
                $subcats = $bdd->query($sql);
                return $subcats->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Throwable $th) {
                $bdd->rollBack();
                $error = fopen("error.txt", "w");
                $txt = $th->getMessage();
                fwrite($error, $txt);
                fclose($error);
            }
        } else {
            try {
                $sql = $bdd->prepare('SELECT * FROM subcat WHERE FK_mother_cat = :catId');
                $sql->bindParam(':catId', $catId);
                $sql->execute();

                return $sql->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Throwable $th) {
                $bdd->rollBack();
                $error = fopen("error.txt", "w");
                $txt = $th->getMessage();
                fwrite($error, $txt);
                fclose($error);
            }
        }
    }

    public static function addSubCat(PDO $bdd, Subcat $newSubcat)
    {
        try {
            $bdd->beginTransaction();
            $NewSubCat = $newSubcat->getTitle();
            $motherCat = $newSubcat->getCat_id();

            $sql = $bdd->prepare('INSERT INTO subcat(title, FK_mother_cat) VALUES (:NewSubCat, :motherCat)');
            $sql->bindParam(':NewSubCat', $NewSubCat);
            $sql->bindParam(':motherCat', $motherCat);
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

    public static function deleteSubCat(PDO $bdd, $id)
    {
        try {
            $bdd->beginTransaction();

            $sql = $bdd->prepare('DELETE FROM subcat WHERE id = :dyingsubcat');
            $sql->bindParam(':dyingsubcat', $id);
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