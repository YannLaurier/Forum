<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";
require_once "classes\Cat.php";
require_once "classes\Subcat.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$cats = Cat::bringCats($bdd);
$subcats = Subcat::bringSubCats($bdd);

$bddManager->disconnectBDD();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php" ?>
    <main >
        <div class="container">
        <h1>Accueil</h1>
        <section>
            <h2>Posts récents</h2>
                <!-- how do I drag w JS data that is accessible only through php ? Can I even display this with php ? This counts as dynamic doesn't it ?-->
        </section>
        <section>
            <h2>Toutes les catégories</h2>
            <?php
            foreach ($cats as $tab) {
                echo '<h3 class="dark list pad-10"><a href="cat.php?id='.$tab["id"].'">' . $tab["title"] . '</a></h3>';
                foreach ($subcats as $tab2) {
                    if ($tab["id"] === $tab2["FK_mother_cat"]) {
                        echo '<p class="list pad-10" ><a href="subcat.php?id='.$tab2["id"].'">' . $tab2["title"] . '</p>';
                    }
                }
            }
            unset($tab);
            ?>
        </section>
        </div>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>