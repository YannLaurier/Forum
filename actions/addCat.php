<?php
session_start();
require_once "../config/BddManager.php" ;
require_once "../config/BddManager.php";

$bdd=new BddManager();
$bdd->connectBDD();


if (isset($_POST["AddCat"])) {
    $catname = $_POST["NewCat"];
    Cat::addCat($catname);
    header('Location:../admin.php');
    }

$bdd->disconnectBDD();