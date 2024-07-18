<?php
session_start();
require_once "../config/config.php" ;
$bdd=new bdd();
$bdd->connectBDD();

if(isset($_POST["AddMod"])){
    $newModName = $_POST["newModName"];

    unset($tab);
    $bdd->addMod($newModName);
    header('Location:../admin.php');
}

$bdd->disconnectBDD();