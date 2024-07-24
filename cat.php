<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";
require_once "classes\Cat.php";
require_once "classes\Subcat.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$catId = $_GET["id"];
settype($catId, "integer");

$thatCat = Cat::bringOneCat($bdd, $catId);
$subcats = Subcat::bringSubCats($bdd, $catId);

$bddManager->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    echo $thatCat["title"];
    ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php" ?>
    <main>
        <div class="container">
            <h1><?php
            echo $thatCat["title"];
            ?></h1>
            <p class="thisEmptyMessage">
                Vous êtes ici :
                <a href="index.php">Accueil</a>
                >
                <a href="cat.php?id=<?php echo $thatCat["id"]; ?>"><?php echo $thatCat["title"]; ?></a>
            <section>
                <p class="p-10">
                    <?php
                    if (!empty($subcats)) {
                        foreach ($subcats as $tab) {
                            ?>
                        <p class="flex between list pad-10"><a href="subcat.php?id=<?php echo  $tab["id"] ; ?>"><?php echo $tab["title"]; ?></a></p>
                        <?php
                        }

                    } else {
                        ?>
                    <p class='thisEmptyMessage'>Il n'y a pas encore de sous-catégories ici. Reviens dans un moment !</p><?php
                    }
                    ?>
                </p>
            </section>
        </div>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>