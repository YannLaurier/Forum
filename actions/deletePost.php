<?php
session_start();
require_once "../config/BddManager.php";
require_once '../classes/Post.php';

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$postId = $_POST["deletePost"];

if (isset($_POST["deletePost"])) {
    Post::deletePost($bdd, $postId);
}

$bddManager->disconnectBDD();
if (isset($_POST["subCat"])) {
    $subCatId = $_POST["subCat"];
    header("Location:../subcat.php?id=$subCatId");
}else{
    header("Location:../dashboard.php");
}
