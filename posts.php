<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";
require_once "classes\Post.php";
require_once "classes\Answer.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$postId = $_GET["id"];
settype($postId, "integer");

$ans = Answer::bringAns($bdd, $postId);
$post = Post::bringOnePost($bdd, $postId);

$message = "";

$bddManager->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    echo $post[0]["postTitle"];
    ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php" ?>
    <main>
        <div class="container">
            <section>
                <h1 class="pad-10">
                    <?php echo $post[0]["postTitle"]; ?>
                </h1>
                <?php
                if (isset($_SESSION["user"])) {
                    if ($_SESSION["user"]["status"] === "admin" || $_SESSION["user"]["status"] === "modo" || $_SESSION["user"]["id"] === $post[0]["FK_author_id"]) {
                        ?>
                        <div class="deletePost flex gap-10">
                            <?php if ($_SESSION["user"]["id"] === $post[0]["FK_author_id"]) { ?>
                                <button class="tinyGuy open" type="button" popovertarget="editPost"
                                    value="<?php echo $post[0]["postId"]; ?>">Modifier</button>
                                <dialog id="popover" class="pad-10" popover>
                                    <form action="actions/editPost.php" method="POST">
                                        <div class="flex">
                                            <input type="text" name="title" placeholder="Titre du sujet"
                                                value="<?php echo $post[0]["postTitle"]; ?>">
                                            <button type="button" class="close">
                                                <svg fill="var(--dark)" xmlns="http://www.w3.org/2000/svg" width="17.828"
                                                    height="17.828">
                                                    <path
                                                        d="m2.828 17.828 6.086-6.086L15 17.828 17.828 15l-6.086-6.086 6.086-6.086L15 0 8.914 6.086 2.828 0 0 2.828l6.085 6.086L0 15l2.828 2.828z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <textarea name="content"><?php echo $post[0]["content"]; ?></textarea>
                                        <button type="submit" name="editPost"
                                            value="<?php echo $post[0]["postId"]; ?>">Modifier</button>
                                    </form>
                                </dialog>
                            <?php } ?>
                            <form action="actions/deletePost.php" method="POST">
                                <input type="hidden" name="subCat" value="<?php echo $post[0]["FK_category_id"]; ?>">
                                <button class="tinyGuy" type="submit" name="deletePost"
                                    value="<?php echo $post[0]["postId"]; ?>">Supprimer</button>
                            </form>
                        </div>
                        <?php
                    }
                }
                ?>
                <p class="thisEmptyMessage">Publié le <?php

                $date = strtotime($post[0]["publication_date"]);
                setlocale(LC_TIME, 'fr_FR');
                date_default_timezone_set('Europe/Paris');
                echo date("d F Y", $date) . " à " . date("h:i", $date);
                ?>
                    dans la sous-catégorie <a
                        href="subcat.php?id=<?php echo $post[0]["subCatId"] ?>"><?php echo $post[0]["subCatTitle"]; ?></a>
                </p>
                <div class="flex between">
                    <div class="flex column">
                        <img class="pad-10" src="<?php
                        if (!empty($post[0]["profilePicData"])) {
                            echo "actions\displayProfilePic.php?id=" . $post[0]["Pseudo"];
                        } else {
                            echo "assets/default.jpg";
                        }
                        ?>" alt="profile pic of <?php echo $post[0]["Pseudo"] ?>">
                        <h2 class="pad-10 ansPseudo"><?php echo $post[0]["Pseudo"]; ?></h2>
                    </div>
                    <p class="pad-10" style="width: 80%;">
                        <?php echo $post[0]["content"]; ?>
                    </p>
                </div>
            </section>
            <section>
                <?php if (!empty($ans)) {
                    foreach ($ans as $key => $tab) {
                        ?>
                        <div class="answers flex list pad-10" name="answer">
                            <div class="flex column profile">
                                <img src=<?php
                                if (!empty($tab["profilePicData"])) {
                                    echo "actions\displayProfilePic.php?id=" . $tab["Pseudo"];
                                } else {
                                    echo "assets/default.jpg";
                                }
                                ?>
                                    alt="profile picture of <?php $tab["Pseudo"] ?>">
                                <h3 class=ansPseudo pad-10"><a href="profil.php?pseudo=<?php
                                echo $tab["Pseudo"] ?>"><?php echo $tab["Pseudo"]; ?></a></h3>
                                <p class="thisEmptyMessage">Le <?php
                                $dateAns = strtotime($tab["time"]);
                                echo date("d F Y", $dateAns) . " à " . date("h:i", $dateAns); ?></p>
                            </div>
                            <div class="flex between ansBody">
                                <p class="ansContent pad-10"><?php echo $tab["content"] ?></p>
                                <?php
                                $baby = array_key_last($ans);
                                if ($key === $baby && $tab["userId"] === $_SESSION["user"]["id"]) {
                                    ?>
                                    <div class="flex gap-10 ansForm">
                                        <button type="button" popovertarget="ModifAns<?php echo $tab["answerId"] ?>"
                                            class="tinyGuy">Modifier</button>
                                        <form action="actions/deleteAnswer.php" method="POST">
                                            <input type="hidden" name="postId" value="<?php echo $_GET["id"] ?>">
                                            <button type="submit" name="DeleteAns" value="<?php echo $tab["answerId"] ?>" class="tinyGuy">Supprimer</button>
                                        </form>
                                        <dialog id="ModifAns<?php echo $tab["answerId"] ?>" popover aria-modal="true">
                                            <form action="actions/editAnswer.php" method="POST" class="flex column">
                                                <input type="hidden" name="postId" value="<?php echo $_GET["id"] ?>">
                                                <textarea class="pad-10" name="newContent"><?php echo $tab["content"]; ?></textarea>
                                                <button class="pad-10" type="submit" name="editAns" class="tinyGuy"
                                                    value="<?php echo $tab["answerId"]; ?>">Modifier</button>
                                            </form>
                                        </dialog>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div> <?php
                    }
                } else {
                    echo "<p class = 'thisEmptyMessage'>Personne n'a encore répondu à ce post. Veux-tu changer cela ?</p>";
                }
                ?>
            </section>
            <section>
                <form method="POST" action="actions/addAnswer.php" class="flex pad-10 gap-10">
                    <textarea type="text" name="AnsContent" placeholder="Tapez votre réponse ici..."></textarea>
                    <button class="tinyGuy" type="submit" name="addAnswer"
                        value="<?php echo $postId; ?>">Répondre</button>
                </form>
            </section>
        </div>
    </main>
    <?php include "components/footer.php"; ?>
</body>

<script type="text/javascript" src="js\popover.js"></script>

</html>