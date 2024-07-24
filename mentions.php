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
    <title>Mentions</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php" ?>
    <main >
        <div class="container">
        <h1>Mentions</h1>
        <section>
          <p>Tous les fichiers SVG utilisés viennent de SVG Repo et sont (normalement) sous license soit MIT soit CC.</p> 
            <p>Le chat/@ utilisé comme logo sur la navbar a été créé par <a href="https://www.svgrepo.com/author/vectordoodle/">vectordoodle</a>.</p>
        </section>
        </div>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>