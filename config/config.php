<?php

class bdd
{
    private $bdd;

    //connexion à BDD
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

    //déconnexion BDD
    public function disconnectBDD()
    {
        $this->bdd = null;
    }

    //compare pseudo & compare email ? comme ça on peut updater individuellement les 2 ? '-'
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

    //AddUser
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
}
