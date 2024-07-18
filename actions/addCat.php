<?php
session_start();
require_once "../config/config.php" ;
$bdd=new bdd();
$bdd->connectBDD();


if (isset($_POST["AddCat"])) {
    $catname = $_POST["NewCat"];
    $bdd->addCat($catname);
    header('Location:../admin.php');
    }

$bdd->disconnectBDD();