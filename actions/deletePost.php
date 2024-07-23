<?php
session_start();
require_once "../config/BddManager.php";
require_once '../classes/Post.php';

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

var_dump($_POST);
$subCatId = $_POST["subCat"];

$postId = $_POST["deletePost"];
$post = Post::bringOnePost($bdd, $postId);


if (isset($_POST["deletePost"])) {
    Post::deletePost($bdd, $postId);
}

$bddManager->disconnectBDD();
header("Location:../subcat.php?id=$subCatId");