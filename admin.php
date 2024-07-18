<?php
session_start();
require_once "classes/user.php";
$bdd = new bdd();
$bdd->connectBDD();

$cats = $bdd->bringCats();
$subcats = $bdd->bringSubCats();
$allMods = $bdd->bringMods();



$bdd->disconnectBDD();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php";
    if (!isset($_SESSION["user"])) {
        echo "<p class= 'message'>Oops ! It appears you're disconnected. Please log in.</p>";
    } elseif ($_SESSION["user"]["status"] !== 'admin') {
        echo "<p class= 'message'>Oops ! You're not allowed to be there. Please depart.</p>";
    } else {
        ?>
        <main>
            <div class="container">
                <h1>Admin Dashboard</h1>
                <section class="flex between">
                    <form action="actions/addCat.php" method="POST" class="miniInput flex column">
                        <h2>Nouvelle catégorie</h2>
                        <label for="NewCat">Nom</label>
                        <input type="text" name="NewCat" id="NewCat">
                        <button type="submit" name="AddCat">Ajouter</button>
                    </form>
                    <form action="actions/addSubCat.php" method="POST" class="miniInput flex column">
                        <h2>Nouvelle Sous-catégorie</h2>
                        <div>
                            <label for="NewSubCat">Nom</label>
                            <input type="text" name="NewSubCat" id="NewSubCat" required>
                        </div>
                        <div class="pad-10">
                            <label for="MotherCat">Catégorie :</label>
                            <select id="MotherCat" name="MotherCat" required>
                                <option value="">sélectionner</option>
                                <?php
                                foreach ($cats as $tab) {
                                    echo '<option value="' . $tab["title"] . '">' . $tab["title"] . '</option>';
                                }
                                unset($tab);
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="AddSubCat">Ajouter</button>
                    </form>
                    <form action="actions/addMod.php" method="POST" class="miniInput flex column">
                        <h2>Nommer modérateur</h2>
                        <div>
                            <label for="newModName">Nom de l'utilisateur</label>
                            <input type="text" name="newModName" id="newModName" required>
                        </div>
                        <button type="submit" name="AddMod">Nominer</button>
                    </form>
                    <form action="actions/deleteMod.php" method="POST" class="miniInput flex column">
                        <h2>Retirer modérateur</h2>
                        <div>
                            <label for="modName">Nom de l'utilisateur</label>
                            <select id="modName" name="modName" required>
                                <option value="">sélectionner</option>
                                <?php
                                foreach ($allMods as $tab) {
                                    echo '<option value="' . $tab["Pseudo"] . '">' . $tab["Pseudo"] . '</option>';
                                }
                                unset($tab);
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="DeleteMod">Déchoir</button>
                    </form>
                    <!-- si temps : ban user mais faut une autre table help-->
                </section>
                <section>
                    <h2>Admin Rights</h2>
                    <p>Admin has access to user list + all posts lists, and can :</p>
                    <ul>
                        <li style="font-weight: bold">Create category</li>
                        <li style="font-weight: bold">Create subcategory</li>
                        <li style="font-weight: bold">Delete category</li>
                        <li style="font-weight: bold">Delete subcategory</li>
                        <li>Delete topic</li>
                        <li>Delete answer</li>
                        <li>Ban user</li>
                        <li>Make someone a moderator</li>
                    </ul>
                </section>
                <section>
                    <h2>Gérer catégories</h2>
                    <?php
                    foreach ($cats as $tab) {
                        echo '<form action="actions/deleteCat.php" class="flex between list pad-10 dark" method = "POST">
                        <h3><a href="cat.php?id='.$tab["id"].'">' . $tab["title"] . '</a></h3>
                        <div class="flex gap-10">
                            <button type="button" name="EditCat" value="' . $tab["title"] . '" class="tinyGuy">Modifier</button>
                            <button type="submit" name="DeleteCat" value="' . $tab["title"] . '" class="tinyGuy">Supprimer</button>
                        </div>
                    </form>';
                        foreach ($subcats as $tab2) {
                            if ($tab["id"] === $tab2["FK_mother_cat"]) {
                                echo '<form action="actions/deleteSubCat.php" class="flex between list pad-10" method = "POST">
                                <p><a href="subcat.php?id='.$tab2["id"].'">' . $tab2["title"] . '</a></p>
                                <div class="flex gap-10">
                                    <button type="button" name="EditSubCat" value="' . $tab["title"] . '" class="tinyGuy">Modifier</button>
                                    <button type="submit" name="DeleteSubCat" value="' . $tab2["title"] . '" class="tinyGuy">Supprimer</button>
                                </div>
                            </form>';
                            }
                        }
                    }
                    unset($tab);
                    ?>
                </section>
            </div>
        </main>
        <?php
    }
    include "components/footer.php" ?>
</body>

</html>