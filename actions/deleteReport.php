<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/Report.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

var_dump($_POST);

if(isset($_POST["deleteReport"])){
    $reportId = $_POST["deleteReport"];

    Report::deleteReport($bdd, $reportId);
}

$bddManager->disconnectBDD();
header("Location:../dashboard.php");