<?php
require_once "../config/config.php" ;
$bdd=new bdd();
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