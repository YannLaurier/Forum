<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/User.php";

$bddManager = new BddManager();
$bdd =$bddManager->connectBDD();

if(isset($_POST["DeleteMod"])){
    $modName = $_POST["modName"];

    User::deleteMod($bdd, $modName);
    header('Location:../admin.php');
}

$bddManager->disconnectBDD();