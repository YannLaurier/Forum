<?php
session_start();
require_once "../config/BddManager.php";
require_once '../classes/Answer.php';

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$ansId = $_POST["DeleteAns"];
settype($ansId, "integer");
var_dump($_POST);

if (isset($_POST["DeleteAns"])) {
    Answer::deleteAnswer($bdd, $ansId);
}

$bddManager->disconnectBDD();
//  if (isset($_POST["postId"])) {
//      $postId = $_POST["postId"];
//      header("Location:../posts.php?id=$postId");
// } else {
//      header("Location:../dashboard.php");
// }
