<?php
session_start();

require_once "classes/user.php";

$bdd = new bdd();
$bdd->connectBDD();

$cats = $bdd->bringCats();
$subcats = $bdd->bringSubCats();

$bdd->disconnectBDD();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php" ?>
    <main class="container">
        <h1>Accueil</h1>
        <section>
            <h2>Posts récents</h2>
                <!-- how do I drag w JS data that is accessible only through php ? Can I display this with php ? This counts as dynamic doesn't it ?-->
        </section>
        <section>
            <h2>Toutes les catégories</h2>
            <?php
            foreach ($cats as $tab) {
                echo '<form class="flex between list pad-10 dark" method = "POST">
                        <h3>' . $tab["title"] . '</h3>
                        <div class="flex gap-10">
                            <button type="submit" name="EditCat" value="' . $tab["title"] . '" class="tinyGuy">Modifier</button>
                            <button type="submit" name="DeleteCat" value="' . $tab["title"] . '" class="tinyGuy">Supprimer</button>
                        </div>
                    </form>';
                foreach ($subcats as $tab2) {
                    if ($tab["id"] === $tab2["FK_mother_cat"]) {
                        echo '<form class="flex between list pad-10" method = "POST">
                                <p>' . $tab2["title"] . '</p>
                                <div class="flex gap-10">
                                    <button type="submit" name="EditSubCat" value="' . $tab["title"] . '" class="tinyGuy">Modifier</button>
                                    <button type="submit" name="DeleteSubCat" value="' . $tab2["title"] . '" class="tinyGuy">Supprimer</button>
                                </div>
                            </form>';
                    }
                }
            }
            unset($tab);
            ?>
        </section>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>