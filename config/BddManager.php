<?php

class BddManager
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
}
