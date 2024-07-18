<?php
session_start();
require_once "../config/config.php";
require_once "../classes/post.php";

$bdd = new bdd();
$bdd->connectBDD();

if (isset($_POST["AddPost"])) {
    $subcats = $bdd->bringSubCats();
    foreach ($subcats as $tab) {
        if ($tab["id"] == $_POST["AddPost"]) {
            $num = $tab["id"];
        }
    }
    settype($num, "integer");

    $title = htmlspecialchars($_POST["title"]);
    $content = htmlspecialchars($_POST["content"]);
    $author = $_SESSION["user"]["id"];

    if (!empty($title) && !empty($content)) {

        $newPost = new post;
        $newPost->setTitle($title);
        $newPost->setContent($content);
        $newPost->setAuthor($author);
        $newPost->setSubCat($num);
        $bdd->addPost($newPost);
        header("Location: ../subcat.php?id=$num");
    }
}

$bdd->disconnectBDD();