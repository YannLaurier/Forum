<?php
session_start();
require_once "../config/BddManager.php";
require_once '../classes/Answer.php';

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

var_dump($_POST);

$postId = $_POST["postId"];
$ansId = $_POST["DeleteAns"];

if (isset($_POST["DeleteAns"])) {
    Answer::deleteAnswer($bdd, $ansId);
}

$bddManager->disconnectBDD();
header("Location:../posts.php?id=$postId");