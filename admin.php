<?php
session_start();

require_once "classes/user.php";

$bdd = new bdd();
$bdd->connectBDD();

$cats = $bdd->bringCats();
$subcats = $bdd->bringSubCats();

if (isset($_POST["AddCat"])) {
    $catname = $_POST["NewCat"];
    $bdd->addCat($catname);
    header('Location:admin.php');
}

if (isset($_POST["AddSubCat"])) {
    $subCatTitle = $_POST["NewSubCat"];
    $MotherCat = $_POST["MotherCat"];

    foreach ($cats as $tab) {
        if ($MotherCat === $tab["title"]) {
            $MotherId = $tab["id"];
        }
        unset($tab);
    }

    $bdd->addSubCat(["NewSubCat" => $subCatTitle, "MotherCat" => $MotherId]);
    header('Location:admin.php');

}

if (isset($_POST["DeleteCat"])) {
    $DyingCat = $_POST["DeleteCat"];
    foreach ($cats as $tab) {
        if ($DyingCat === $tab["title"]) {
            $DyingId = $tab["id"];
        }
        unset($tab);
    }
    $bdd->deleteCat($DyingId);
    header('Location:admin.php');
}

if (isset($_POST["DeleteSubCat"])) {
    $DyingSubCat = $_POST["DeleteCat"];
    foreach ($subcats as $tab) {
        if ($DyingSubCat === $tab["title"]) {
            $DyingSubId = $tab["id"];
        }
        unset($tab);
    }
    $bdd->deleteSubCat($DyingSubId);
    header('Location:admin.php');
}

// if (isset($_POST["EditCat"])) {
//     $growingCat = $_POST["EditCat"];
//         foreach ($cats as $tab) {
//             if($growingCat === $tab["title"]){
//                 $growingId = $tab["id"];
//             }
//         }
//         unset($tab);
//     $bdd->updateCat($growingId);
//     header('Location:admin.php');
// }

// if (isset($_POST["EditSubCat"])) {
//     $growingCat = $_POST["EditSubCat"];
//         foreach ($subcats as $tab) {
//             if($growingSubCat === $tab["title"]){
//                 $growingSubId = $tab["id"];
//             }
//         }
//         unset($tab);
//     $bdd->updateSubCat($growingSubId);
//     header('Location:admin.php');
// }



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
        <main class="container">
            <h1>Admin Dashboard</h1>
            <section class="flex between">
                <form method="POST" class="miniInput flex column">
                    <h2>Nouvelle catégorie</h2>
                    <label for="NewCat">Nom</label>
                    <input type="text" name="NewCat" id="NewCat">
                    <button type="submit" name="AddCat">Ajouter</button>
                </form>
                <form method="POST" class="miniInput flex column">
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
                    echo '<form class="flex between list pad-10 dark" method = "POST">
                        <h3>' . $tab["title"] . '</h3>
                        <div class="flex gap-10">
                            <button type="submit" name="EditCat" value="' . $tab["title"] . '" class="tinyGuy">Modifier</button>
                            <button type="submit" name="DeleteCat" value="' . $tab["title"] . '" class="tinyGuy">Supprimer</button>
                        </div>
                    </form>'; 
                    foreach($subcats as $tab2){
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
        <?php
    }
    include "components/footer.php" ?>
</body>

</html>