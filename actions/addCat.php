<?php
session_start();
require_once "../config/BddManager.php" ;
require_once "../classes/Cat.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();


if (isset($_POST["AddCat"])) {
    $catname = $_POST["NewCat"];
    Cat::addCat($bdd, $catname);
    header('Location:../dashboard.php');
    }

$bddManager->disconnectBDD();