<?php
session_start();
require_once "../config/BddManager.php";
require_once '../classes/Subcat.php';

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$subcats = Subcat::bringSubCats($bdd);

if (isset($_POST["DeleteSubCat"])) {

    $DyingSubId = $_POST["DeleteSubCat"];
    
    Subcat::deleteSubCat($bdd, $DyingSubId);
}

$bddManager->disconnectBDD();
header('Location:../dashboard.php');