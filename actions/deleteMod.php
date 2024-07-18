<?php
session_start();
require_once "../config/config.php" ;
$bdd=new bdd();
$bdd->connectBDD();

if(isset($_POST["DeleteMod"])){
    $modName = $_POST["modName"];

    $bdd->deleteMod($modName);
    header('Location:../admin.php');
}

$bdd->disconnectBDD();