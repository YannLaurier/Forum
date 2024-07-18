<?php
require_once "../config/config.php";
$bdd = new bdd();
$bdd->connectBDD();

$subcats = $bdd->bringSubCats();

if (isset($_POST["DeleteSubCat"])) {
    $DyingSubCat = $_POST["DeleteSubCat"];
    foreach ($subcats as $tab) {
        if ($DyingSubCat === $tab["title"]) {
            $DyingSubId = $tab["id"];
        }
        unset($tab);
    }
    $bdd->deleteSubCat($DyingSubId);
    header('Location:../admin.php');
}

$bdd->disconnectBDD();