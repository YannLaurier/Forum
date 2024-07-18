<?php
require_once "../config/config.php" ;
$bdd=new bdd();
$bdd->connectBDD();

$cats = $bdd->bringCats();

if (isset($_POST["DeleteCat"])) {
    $DyingCat = $_POST["DeleteCat"];
    foreach ($cats as $tab) {
    if ($DyingCat === $tab["title"]) {
    $DyingId = $tab["id"];
    }
    unset($tab);
    }
    $bdd->deleteCat($DyingId);
    header('Location:../admin.php');
    }

    $bdd->disconnectBDD();