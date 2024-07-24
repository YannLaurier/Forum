<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/Report.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

if (isset($_POST["reportPost"])) {
    $reason = $_POST["reason"];
    $reporterId = $_SESSION["user"]["id"];
    $postId = $_POST["reportPost"];
    $details = $_POST["details"];

    $newReport = new Report;
    $newReport->setReporterId($reporterId);
    $newReport->setPostId($postId);
    $newReport->setReason($reason);
    $newReport->setDetails($details);
    Report::addReport($bdd, $newReport);
}elseif(isset($_POST["reportAns"])){
    $postId = $_POST["postId"];
    $reason = $_POST["reason"];
    $reporterId = $_SESSION["user"]["id"];
    $ansId = $_POST["reportAns"];
    $details = $_POST["details"];

    $newReport = new Report;
    $newReport->setReporterId($reporterId);
    $newReport->setPostId($postId);
    $newReport->setAnswerId($ansId);
    $newReport->setReason($reason);
    $newReport->setDetails($details);
    Report::addReport($bdd, $newReport);
}

$bddManager->disconnectBDD();
header("Location:../posts.php?id=$postId");