<?php
session_start();
require_once "../config/config.php";
require_once "../classes/answer.php";

$bdd = new bdd();
$bdd->connectBDD();

if (isset($_POST["addAnswer"])) {
    $content = $_POST["AnsContent"];
        $author = $_SESSION["user"]["id"];
        $post = $_POST["addAnswer"];
        var_dump($_POST);

    if (!empty($content)) {

        $newAns = new answer;
        $newAns->setContent($content);
        $newAns->setAuthor($author);
        $newAns->setPost($post);
        $bdd->addAns($newAns);
        header("Location: ../posts.php?id=$post");
    }
}


$bdd->disconnectBDD();