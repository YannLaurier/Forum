<?php
session_start();
require_once "classes/user.php";

$bdd = new bdd();
$bdd->connectBDD();

$subcats = $bdd->bringSubCats();

$dracula = $_SERVER['REQUEST_URI'];
$num = substr($dracula, -1);
settype($num, "integer");


$bdd->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    foreach ($subcats as $tab) {
        if ($tab["id"] === $num) {
            echo $tab["title"];
        }
    }
    ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php" ?>
    <main>
        <div class="container">
            <h1><?php
            foreach ($subcats as $tab) {
                if ($tab["id"] === $num) {
                    echo $tab["title"];
                }
            }
            ?></h1>
            <section>
                <p class="p-10">
                The posts are going to be in there when I actually have them o/
                Insert here normal forum warning about checking your topic is not redundant before posting, or whatever
                <button type="button" class="open" popovertarget="newPostForm" >New post</button>
                <dialog id="popover" class="pad-10" popover>
                    <form method = "POST" action="actions/addPost" class="flex column">
                        <div class="flex">
                            <input type="text" name="title" placeholder="Titre du sujet">
                            <button type="button" class="close">
                            <svg fill="var(--dark)" xmlns="http://www.w3.org/2000/svg" width="17.828" height="17.828"><path d="m2.828 17.828 6.086-6.086L15 17.828 17.828 15l-6.086-6.086 6.086-6.086L15 0 8.914 6.086 2.828 0 0 2.828l6.085 6.086L0 15l2.828 2.828z"/></svg>
                            </button>
                        </div>
                        <textarea name="content" id="" placeholder="Tapez des détails ici..."></textarea>
                        <button type="submit" name="AddPost">Poster</button>
                    </form>
                </dialog>
                <?php
                // foreach ($subcats as $tab) {
                //     if ($tab["FK_mother_cat"] === $num) {
                //         echo '<form action="actions/deleteSubCat.php" class="flex between list pad-10" method = "POST">
                //                 <p>' . $tab["title"] . '</p>
                //                 <div class="flex gap-10">
                //                     <button type="button" name="EditSubCat" value="' . $tab["title"] . '" class="tinyGuy">Modifier</button>
                //                     <button type="submit" name="DeleteSubCat" value="' . $tab["title"] . '" class="tinyGuy">Supprimer</button>
                //                 </div>
                //             </form>';
                //     }
                // }
                ?>
                </p>
            </section>
        </div>
    </main>
    <?php include "components/footer.php" ?>

    <script type="text/javascript" src="js\popover.js"></script>

</body>
</html>