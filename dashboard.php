<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";
require_once "classes\Cat.php";
require_once "classes\Subcat.php";
require_once "classes\Post.php"; //raison : afficher nombre posts à côté de chaque subcat

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$cats = Cat::bringCats($bdd);
$subcats = Subcat::bringSubCats($bdd);
$allMods = User::bringMods($bdd);
$allPseudos = User::bringUsersPseudos($bdd);

$bddManager->disconnectBDD();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php";
    if (!isset($_SESSION["user"])) {
        echo "<section><p class= 'message'>Oops ! Il semble que tu ne sois pas connecté. Connecte-toi et réessaie.</p></section>";
    } elseif ($_SESSION["user"]["status"] !== 'admin' && $_SESSION["user"]["status"] !== 'modo') {
        echo "<section><p class= 'message'>Oops ! Tu n'es pas autorisé à être ici. Dégage.</p></session>";
    } else {
        ?>
        <main>
            <div class="container">
                <h1>Dashboard</h1>
                <section>
                    <p>Salut, <?php echo $_SESSION["user"]["Pseudo"]; ?> ! Voici ton interface
                        <?php if ($_SESSION["user"]["status"] === "modo") {
                            echo "de modo";
                        } elseif ($_SESSION["user"]["status"] === "admin") {
                            echo "d'admin";
                        } ?>
                        . Ceci est maintenant un jeu de gestion. Bonne chance.
                    </p>
                    <P><a href="reportsGestion.php">Gérer les signalements</a></P>
                </section>
                <section class="flex between wrap">
                    <?php if ($_SESSION["user"]["status"] === "admin") { ?>
                        <form action="actions/addCat.php" method="POST" class="miniInput flex column">
                            <h2>Nouvelle catégorie</h2>
                            <label for="NewCat">Nom</label>
                            <input type="text" name="NewCat" id="NewCat">
                            <button type="submit" name="AddCat">Ajouter</button>
                        </form>
                    <?php } ?>
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
                    <?php if ($_SESSION["user"]["status"] === "admin") { ?>
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
                                <label for="modName">Nom de l'utilisateur : </label>
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
                    <?php } ?>
                    <!-- si temps : ban user mais faut rajouter un bool aux user, help-->
                </section>
                <section>
                    <h2>Gérer catégories</h2>
                    <?php
                    foreach ($cats as $tab) { ?>
                        <div class="flex between list pad-10 dark">
                            <h3><a href="cat.php?id=<?php echo $tab["id"]; ?>"><?php echo $tab["title"]; ?></a></h3>
                            <?php if ($_SESSION["user"]["status"] === "admin") { ?>
                                <div class="flex gap-10">
                                    <button type="button" class="tinyGuy"
                                        popovertarget="ModifCat<?php echo $tab["id"] ?>">Modifier</button>
                                    <form action="actions/deleteCat.php" method="POST">
                                        <button type="submit" name="DeleteCat" value="<?php echo $tab["id"]; ?>"
                                            class="tinyGuy">Supprimer</button>
                                    </form>
                                    <dialog id="ModifCat<?php echo $tab["id"] ?>" popover aria-modal="true">
                                        <div class="miniModal">
                                            <form action="actions/editCat.php" method="POST" class="flex">
                                                <input class="pad-10 miniModalElement" name="newTitle" type="text"
                                                    value="<?php echo $tab["title"]; ?>">
                                                <button class="pad-10 miniModalElement" type="submit" name="editCat" class="tinyGuy"
                                                    value="<?php echo $tab["id"]; ?>">Confirmer</button>
                                            </form>
                                        </div>
                                    </dialog>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                        foreach ($subcats as $tab2) {
                            if ($tab["id"] === $tab2["FK_mother_cat"]) { ?>
                                <div class="flex between list pad-10">
                                    <p><a href="subcat.php?id=<?php echo $tab2["id"] ?>"><?php echo $tab2["title"] ?></a></p>
                                    <div class="flex gap-10">
                                        <button type="button" popovertarget="ModifSubcat<?php echo $tab2["id"] ?>"
                                            class="tinyGuy">Modifier</button>
                                        <form action="actions/deleteSubCat.php" method="POST">
                                            <button type="submit" name="DeleteSubCat" value="<?php echo $tab2["id"] ?>"
                                                class="tinyGuy">Supprimer</button>
                                        </form>
                                        <dialog id="ModifSubcat<?php echo $tab2["id"] ?>" popover aria-modal="true">
                                            <div class="miniModal">
                                                <form action="actions/editSubCat.php" method="POST" class="flex">
                                                    <select id="MotherCat" name="MotherCat" required>
                                                        <option value="">sélectionner</option>
                                                        <?php
                                                        foreach ($cats as $tab3) {
                                                            echo '<option value="' . $tab3["id"] . '">' . $tab3["title"] . '</option>';
                                                        }
                                                        unset($tab3);
                                                        ?>
                                                    </select>
                                                    <input class="pad-10 miniModalElement" type="text" name="newSubTitle"
                                                        placeholder="Nouveau nom pour ta sous-catégorie">
                                                    <button class="pad-10 miniModalElement" type="submit" name="EditSubCat"
                                                        class="tinyGuy" value="<?php echo $tab2["id"]; ?>">Confirmer</button>
                                                </form>
                                            </div>
                                        </dialog>
                                    </div>
                                </div>
                                <?php
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