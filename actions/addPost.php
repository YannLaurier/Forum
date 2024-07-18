<?php
require_once "../config/config.php" ;
$bdd=new bdd();
$bdd->connectBDD();


if (isset($_POST["AddPost"])) {
    $post = new post;
    //faire classe obj post avec titre, content, get/set
    //utiliser ça pour envoyer les données en BDD
    //faire fonction addPost en bdd
    //mettre chaque obj (cat, subcat) dans une classe objet et changer les fonctions pour que ça créée un objet à chaque fois
    //puis voir comment faire pour mettre les fonctions dans les classes de leurs objets et pas dans config comme un gros sale
    //et puis on est bien

    $postTitle = $_POST["title"];
    $postContent = $_POST["content"];
    $bdd->addPost([]);
    header('Location:../admin.php');
    }

$bdd->disconnectBDD();