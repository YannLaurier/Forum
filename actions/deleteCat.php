<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/Cat.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$cats = Cat::bringCats($bdd);

if (isset($_POST["DeleteCat"])) {
    $catId = $_POST["DeleteCat"];
    Cat::deleteCat($bdd, $catId);
}

$bddManager->disconnectBDD();
header('Location:../dashboard.php');