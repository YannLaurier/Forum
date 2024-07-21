<?php
session_start();
require_once "../classes/Cat.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$cats = Cat::bringCats($bdd);

if (isset($_POST["DeleteCat"])) {
    $DyingCat = $_POST["DeleteCat"];
    
    Cat::deleteCat($DyingCat, $bdd);
    header('Location:../admin.php');
}

$bddManager->disconnectBDD();