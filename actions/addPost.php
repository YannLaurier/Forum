<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/Post.php";
require_once "../classes/Subcat.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

if (isset($_POST["AddPost"])) {
    $subcats = Subcat::bringSubCats($bdd);
    foreach ($subcats as $tab) {
        if ($tab["id"] == $_POST["AddPost"]) {
            $id = $tab["id"];
        }
    }
    settype($id, "integer");

    $title = htmlspecialchars($_POST["title"]);
    $content = htmlspecialchars($_POST["content"]);
    $author = $_SESSION["user"]["id"];

    if (!empty($title) && !empty($content)) {

        $newPost = new Post;
        $newPost->setTitle($title);
        $newPost->setContent($content);
        $newPost->setAuthor($author);
        $newPost->setSubCat($id);
        Post::addPost($bdd, $newPost);
        header("Location: ../subcat.php?id=$id");
    }
}

$bddManager->disconnectBDD();