<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/Post.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

if(isset($_POST["editPost"])){
    $title = $_POST["title"];
    $content = $_POST["content"];
    $id = $_POST["editPost"];

    Post::editPost($bdd, $title, $content, $id);
}

$bddManager->disconnectBDD();
header("Location:../posts.php?id=$id");