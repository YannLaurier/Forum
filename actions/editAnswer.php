<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/Answer.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$postId = $_POST["postId"];

if(isset($_POST["editAns"])){
    $content = $_POST["newContent"];
    $id = $_POST["editAns"];

    Answer::editAnswer($bdd, $content, $id);
}

$bddManager->disconnectBDD();
header("Location:../posts.php?id=$postId");