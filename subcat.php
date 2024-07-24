<?php
session_start();
require_once "config/BddManager.php";
require_once "classes/User.php";
require_once "classes/Post.php";
require_once "classes/Subcat.php";
require_once "classes/Answer.php";
require_once "classes/Cat.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$subCatId = $_GET["id"];
settype($subCatId, "integer");

$thatSubCat = Subcat::bringOneSubCat($bdd, $subCatId);
$thatCat = Cat::bringOneCat($bdd, $thatSubCat["FK_mother_cat"]);
$posts = Post::bringPosts($bdd);


$bddManager->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    $thatSubCat["title"];
    ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php" ?>
    <main>
        <div class="container">
            <h1><?php
            echo $thatSubCat["title"];
            ?></h1>
            <p class="thisEmptyMessage">
                Vous êtes ici :
                <a href="index.php">Accueil</a>
                >
                <a href="cat.php?id=<?php echo $thatCat["id"]; ?>"><?php echo $thatCat["title"]; ?></a>
                >
                <a href="subcat.php?id=<?php echo $thatSubCat["id"]; ?>"><?php echo $thatSubCat["title"]; ?></a>
            </p>
            <section>
                <p class="p-10"> Merci de bien vouloir payer attention aux topics existants et bien vérifier que votre
                    topic ne fait pas doublon avec un autre. Merci de bien vouloir contacter l'admin pour détails y
                    afférents.</p>
                <button type="button" class="open">New post</button>
                <dialog id="popover" class="pad-10" popover>
                    <form method="POST" action="actions/addPost.php" class="flex column">
                        <div class="flex">
                            <input type="text" name="title" placeholder="Titre du sujet">
                            <button type="button" class="close">
                                <svg fill="var(--dark)" xmlns="http://www.w3.org/2000/svg" width="17.828"
                                    height="17.828">
                                    <path
                                        d="m2.828 17.828 6.086-6.086L15 17.828 17.828 15l-6.086-6.086 6.086-6.086L15 0 8.914 6.086 2.828 0 0 2.828l6.085 6.086L0 15l2.828 2.828z" />
                                </svg>
                            </button>
                        </div>
                        <textarea name="content" placeholder="Tapez des détails ici..."></textarea>
                        <button type="submit" name="AddPost" value="<?php echo $subCatId ?>">Poster</button>
                    </form>
                </dialog>
            </section>
            <section class="flex column">
                <?php
                foreach ($posts as $tab) {
                    if ($tab["FK_category_id"] === $subCatId) {
                        ?>
                        <div class="flex list pad-10 between">
                            <p>
                                <a href="posts.php?id=<?php echo $tab["id"] ?>"><?php echo $tab["title"]; ?></a>
                            </p>
                            <div class="flex gap-10">
                            <svg  height="20px" width="20px" version="1.1" id="_x32_"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        fill="var(--text-color)" viewBox="0 0 512 512" xml:space="preserve">
                                        <g>
                                            <path class="st0" d="M343.644,129.572c25.132,0,49.092,4.961,71.144,13.708C384.072,62.48,305.95,5.048,214.381,5.048 C95.985,5.048,0,101.033,0,219.433c0,52.546,18.935,100.658,50.315,137.936l-25.09,101.664l123.555-35.476 c10.935,3.509,22.274,6.114,33.893,7.85c-20.773-30.876-32.924-68.016-32.924-107.946 C149.749,216.551,236.728,129.572,343.644,129.572z" />
                                            <path class="st0" d="M512,327.249c0-88.798-71.988-160.787-160.782-160.787c-88.803,0-160.792,71.989-160.792,160.787 c0,88.799,71.988,160.787,160.792,160.787c17.161,0,33.69-2.716,49.198-7.693l92.668,26.609l-18.814-76.246 C497.804,402.748,512,366.661,512,327.249z" />
                                        </g>
                                    </svg>
                                <p>
                                    <?php
                                    $nbAns = Answer::countAns($bdd, $tab["id"]);
                                    if (isset($nbAns[0]["COUNT(*)"])) {
                                        echo $nbAns[0]["COUNT(*)"];
                                    } else {
                                        echo "0";
                                    }
                                    ?>
                                </p>
                                <?php
                                if (isset($_SESSION["user"])) {
                                    if ($_SESSION["user"]["status"] === "admin" || $_SESSION["user"]["status"] === "modo" || $_SESSION["user"]["id"] === $tab["FK_author_id"]) {
                                        ?>
                                        <form action="actions/deletePost.php" method="POST">
                                            <input type="hidden" name="subCat" value="<?php echo $tab["FK_category_id"]; ?>">
                                            <button class="tinyGuy" type="submit" name="deletePost"
                                                value="<?php echo $tab["id"]; ?>">Supprimer</button>
                                        </form>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
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