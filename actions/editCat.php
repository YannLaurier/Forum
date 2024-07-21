<?php
session_start();
require_once "../config/BddManager.php" ;
$bdd=new BddManager();
$bdd->connectBDD();

// if (isset($_POST["EditCat"])) {
    // $growingCat = $_POST["EditCat"];
    // foreach ($cats as $tab) {
    // if($growingCat === $tab["title"]){
    // $growingId = $tab["id"];
    // }
    // }
    // unset($tab);
    // $bdd->updateCat($growingId);
    // header('Location:../admin.php');
    // }

$bdd->disconnectBDD();