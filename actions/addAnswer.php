<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/Answer.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

if (isset($_POST["addAnswer"])) {
        $content = $_POST["AnsContent"];
        $author = $_SESSION["user"]["id"];
        $post = $_POST["addAnswer"];

    if (!empty($content)) {
        $newAns = new Answer;
        $newAns->setContent($content);
        $newAns->setAuthor($author);
        $newAns->setPost($post);
        Answer::addAns($bdd, $newAns);
        header("Location: ../posts.php?id=$post");
    }
}


$bddManager->disconnectBDD();