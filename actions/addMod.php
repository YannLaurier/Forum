<?php
session_start();
require_once "../config/BddManager.php" ;
require_once "../classes/User.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

if(isset($_POST["AddMod"])){
    $newModName = $_POST["newModName"];

    unset($tab);
    User::addMod($bdd, $newModName);
    header('Location:../dashboard.php');
}

$bddManager->disconnectBDD();