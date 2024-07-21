<?php
session_start();
require_once "../config/BddManager.php" ;
$bdd=new BddManager();
$bdd->connectBDD();

// if (isset($_POST["EditSubCat"])) {
    // $growingCat = $_POST["EditSubCat"];
    // foreach ($subcats as $tab) {
    // if($growingSubCat === $tab["title"]){
    // $growingSubId = $tab["id"];
    // }
    // }
    // unset($tab);
    // $bdd->updateSubCat($growingSubId);
    // header('Location:../admin.php');
    // }

$bdd->disconnectBDD();