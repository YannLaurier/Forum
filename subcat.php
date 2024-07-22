<?php
session_start();
require_once "config/BddManager.php";
require_once "classes/User.php";
require_once "classes/Post.php";
require_once "classes/Subcat.php";
require_once "classes/Answer.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$subcats = Subcat::bringSubCats($bdd);
$posts = Post::bringPosts($bdd);

$numberAns = Answer::countAns($bdd);

$subCatId = $_GET["id"];
settype($subCatId, "integer");

$bddManager->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    foreach ($subcats as $tab) {
        if ($tab["id"] === $subCatId) {
            echo $tab["title"];
        }
    }
    ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php" ?>
    <main>
        <div class="container">
            <h1><?php
            foreach ($subcats as $tab) {
                if ($tab["id"] === $subCatId) {
                    echo $tab["title"];
                }
            }
            ?></h1>
            <section>
                <p class="p-10"> Merci de bien vouloir payer attention aux topics existants et bien vérifier que votre topic ne fait pas doublon avec un autre. Merci de bien vouloir contacter l'admin pour détails y afférents.</p>
                <button type="button" class="open" popovertarget="newPostForm">New post</button>
                <dialog id="popover" class="pad-10" popover>
                    <form method = "POST" action="actions/addPost.php" class="flex column">
                        <div class="flex">
                            <input type="text" name="title" placeholder="Titre du sujet">
                            <button type="button" class="close">
                            <svg fill="var(--dark)" xmlns="http://www.w3.org/2000/svg" width="17.828" height="17.828"><path d="m2.828 17.828 6.086-6.086L15 17.828 17.828 15l-6.086-6.086 6.086-6.086L15 0 8.914 6.086 2.828 0 0 2.828l6.085 6.086L0 15l2.828 2.828z"/></svg>
                            </button>
                        </div>
                        <textarea name="content" id="" placeholder="Tapez des détails ici..."></textarea>
                        <button type="submit" name="AddPost" value="<?php echo $subCatId ?>">Poster</button>
                    </form>
                </dialog>
                </section>
                <section>
                <?php
                foreach ($posts as $tab) {
                     if ($tab["FK_category_id"] === $subCatId) {
                         ?>
                         <div class="flex list pad-10">
                            <p><a href="posts.php?id=<?php echo $tab["id"] ?>"><?php echo $tab["title"]; ?></a></p>
                            <p><?php ?></p>
                        </div>
                         <?php
                     }
                }
                ?>
                </p>
            </section>
        </div>
    </main>
    <?php include "components/footer.php" ?>

    <script type="text/javascript" src="js\popover.js"></script>

</body>
</html>