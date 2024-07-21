<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";
require_once "classes\Cat.php";

$bdd = new BddManager();
$bdd = $bddManager->connectBDD();

$subcatId = $_GET["id"];
settype($subcatId, "integer");

$cats = Cat::bringCats($bdd);
$subcats = Subcat::bringSubCats($bbd, $subcatId);

$bddManager->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    foreach ($cats as $tab) {
        if ($tab["id"] === $subcatId) {
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
                if ($tab["id"] === $subcatId) {
                    echo $tab["title"];
                }
            }
            ?></h1>
            <section>
                <p class="p-10">
                <?php
                if(!empty($subcats)){
                foreach ($subcats as $tab) {
                        echo '<form action="actions/deleteSubCat.php" class="flex between list pad-10" method = "POST">
                                <p>' . $tab["title"] . '</p>
                                <div class="flex gap-10">
                                    <button type="button" name="EditSubCat" value="' . $tab["title"] . '" class="tinyGuy">Modifier</button>
                                    <button type="submit" name="DeleteSubCat" value="' . $tab["title"] . '" class="tinyGuy">Supprimer</button>
                                </div>
                            </form>';
                    }
                    
                }else{
                    echo "<p class='thisEmptyMessage'>Il n'y a pas encore de sous-catégories ici. Reviens dans un moment !</p>";
                }
                ?>
                </p>
            </section>
        </div>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>