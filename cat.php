<?php
session_start();
require_once "classes/user.php";

$bdd = new bdd();
$bdd->connectBDD();

$cats = $bdd->bringCats();
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
    foreach ($cats as $tab) {
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
            foreach ($cats as $tab) {
                if ($tab["id"] === $num) {
                    echo $tab["title"];
                }
            }
            ?></h1>
            <section>
                <p class="p-10">
                <?php
                foreach ($subcats as $tab) {
                    if ($tab["FK_mother_cat"] === $num) {
                        echo '<form action="actions/deleteSubCat.php" class="flex between list pad-10" method = "POST">
                                <p>' . $tab["title"] . '</p>
                                <div class="flex gap-10">
                                    <button type="button" name="EditSubCat" value="' . $tab["title"] . '" class="tinyGuy">Modifier</button>
                                    <button type="submit" name="DeleteSubCat" value="' . $tab["title"] . '" class="tinyGuy">Supprimer</button>
                                </div>
                            </form>';
                    }
                }
                ?>
                </p>
            </section>
        </div>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>