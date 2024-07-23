<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/Subcat.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

if (isset($_POST["EditSubCat"])) {

    $title = $_POST["newSubTitle"];
    $MotherCat = $_POST["MotherCat"];
    $id = $_POST["EditSubCat"];
    settype($MotherCat, "integer");
    settype($id, "integer");

    Subcat::editSubCat($bdd, $title, $id, $MotherCat);
}

$bddManager->disconnectBDD();
header("Location:../dashboard.php");