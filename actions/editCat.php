<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/Cat.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

if (isset($_POST["editCat"])) {

    $title = $_POST["newTitle"];
    $id = $_POST["editCat"];

    Cat::editCat($bdd, $title, $id);
}

$bddManager->disconnectBDD();
header("Location:../dashboard.php");