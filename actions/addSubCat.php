<?php
session_start();
require_once "../config/config.php" ;

$bdd=new bdd();
$bdd->connectBDD();
$cats = $bdd->bringCats();

if (isset($_POST["AddSubCat"])) {
    $subCatTitle = $_POST["NewSubCat"];
    $MotherCat = $_POST["MotherCat"];

    foreach ($cats as $tab) {
        if ($MotherCat === $tab["title"]) {
            $MotherId = $tab["id"];
        }
    }
    unset($tab);

    $bdd->addSubCat(["NewSubCat" => $subCatTitle, "MotherCat" => $MotherId]);
    header('Location:../admin.php');
}

$bdd->disconnectBDD();