<?php
require './config/config.php';

class user extends bdd
{
    private $pseudo;
    private $pass;
    private $email;
    private $pdp;

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
}