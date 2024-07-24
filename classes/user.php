<?php

class User
{
    private string $pseudo;
    private string $pass;
    private string $email;
    private string $pdp;

    public function setPdp($pdp)
    {
        $this->pdp = $pdp;
    }
    public function getPdp()
    {
        return $this->pdp;
    }
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public static function addUser(PDO $bdd, User $user)
    {
        try {
            $bdd->beginTransaction();
            $pseudo = $user->getPseudo();
            $pass = $user->getPass();
            $email = $user->getEmail();
            $status = "user";

            $sql = $bdd->prepare('INSERT INTO user(Pseudo, email, Pass, status) VALUES (:pseudo, :email, :pass, :status)');
            $sql->bindParam(':pseudo', $pseudo);
            $sql->bindParam(':pass', $pass);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':status', $status);
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

    public static function comparePseudo(PDO $bdd, $pseudo = ""): bool
    {
        $sql = $bdd->prepare('SELECT * FROM user WHERE pseudo = :pseudo');
        $sql->bindParam(':pseudo', $pseudo);
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

    public static function compareEmail(PDO $bdd, $mail = ""): bool
    {
        $sql = $bdd->prepare('SELECT * FROM user WHERE email = :email');
        $sql->bindParam(':email', $mail);
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

    public static function bringMods(PDO $bdd)
    {
        try {
            $sql = 'SELECT * FROM user WHERE status = "modo"';
            $allMods = $bdd->query($sql);
            return $allMods->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $bdd->rollBack();
            $error = fopen("error.txt", "w");
            $txt = $th->getMessage();
            fwrite($error, $txt);
            fclose($error);
        }
    }

    public static function addMod(PDO $bdd, $newMod)
    {
        try {
            $bdd->beginTransaction();

            $sql = $bdd->prepare('UPDATE user SET status = "modo" WHERE Pseudo = :newMod');
            $sql->bindParam(':newMod', $newMod);
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

    public static function deleteMod(PDO $bdd, $fallenMod)
    {
        try {
            $bdd->beginTransaction();

            $sql = $bdd->prepare('UPDATE user SET status = "user" WHERE Pseudo = :fallenMod');
            $sql->bindParam(':fallenMod', $fallenMod);
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

    public static function editProfilePic(PDO $bdd, $filename, $filetype, $data, $id)
    {
        try {
            $bdd->beginTransaction();

            $sql = $bdd->prepare("UPDATE user
            SET profilePicFilename = :filename,  profilePicType = :filetype,  profilePicData = :data
            WHERE id = :id");
            $sql->bindParam(':filename', $filename);
            $sql->bindParam(':filetype', $filetype);
            $sql->bindParam(':data', $data);
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

    public static function bringOneUser(PDO $bdd, $pseudo) :array
    {
        try {
            $sql = $bdd->prepare('SELECT * FROM user WHERE pseudo = :pseudo;');
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

    public static function updateUser(PDO $bdd, $pseudo, $description, $email, $id)
    {
        try {
            $bdd->beginTransaction();

            $sql = $bdd->prepare("UPDATE user
            SET Pseudo = :pseudo,  description = :description,  email = :email
            WHERE id = :id");
            $sql->bindParam(':description', $description);
            $sql->bindParam(':pseudo', $pseudo);
            $sql->bindParam(':email', $email);
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

    public static function bringUsersPseudos(PDO $bdd)
    {
        {
            try {
                $sql ='SELECT Pseudo, id FROM user';
                $allPseudos = $bdd->query($sql);
            return $allPseudos->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Throwable $th) {
                $error = fopen("error.txt", "w");
                $txt = $th->getMessage();
                fwrite($error, $txt);
                fclose($error);
            }
        }
    }
}