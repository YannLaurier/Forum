<?php
session_start();
require_once "../config/BddManager.php" ;

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();
$cats = Cat::bringCats($bdd);

if (isset($_POST["AddSubCat"])) {
    $subCatTitle = $_POST["NewSubCat"];
    $MotherCat = $_POST["MotherCat"];

    foreach ($cats as $tab) {
        if ($MotherCat === $tab["title"]) {
            $MotherId = $tab["id"];
        }
    }
    unset($tab);

    Subcat::addSubCat($bdd, ["NewSubCat" => $subCatTitle, "MotherCat" => $MotherId]);
    header('Location:../admin.php');
}

$bddManager->disconnectBDD();