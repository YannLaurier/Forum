<?php
session_start();

require_once "classes/user.php";

$bdd = new bdd();
$bdd->connectBDD();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "components/navbar.php" ?>
    <main class="container">
        <p>wow I'm doing such a good job right now you have not a single idea</p>
    </main>
</body>

</html>