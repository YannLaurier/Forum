<?php
session_start();
require_once "../config/BddManager.php" ;
require_once "../classes/Subcat.php";
require_once "../classes/Cat.php";

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

    $newSubcat = new Subcat;
    $newSubcat->setTitle($subCatTitle);
    $newSubcat->setCat_id($MotherId);

    Subcat::addSubCat($bdd, $newSubcat);
    header('Location:../dashboard.php');
}

$bddManager->disconnectBDD();