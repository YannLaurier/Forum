<?php
session_start();

require_once "classes/user.php";

$bdd = new bdd();
$bdd->connectBDD();

$bdd->disconnectBDD();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "components/navbar.php";
    if (!isset($_SESSION["user"])) {
        echo "<p class= 'message'>Oops ! It appears you're disconnected. Please log in.</p>";
    } elseif ($_SESSION["user"]["status"] !== 'admin') {
        echo "<p class= 'message'>Oops ! You're not allowed to be there. Please depart.</p>";
    } else {
        ?>
        <main class="container">
            <h1>Admin Dashboard</h1>
            <p>Admin has access to user list + all posts lists, and can :</p>
            <ul>
                <li>Create category</li>
                <li>Create subcategory</li>
                <li>Delete category</li>
                <li>Delete subcategory</li>
                <li>Delete topic</li>
                <li>Delete answer</li>
                <li>Ban user</li>
                <li>Make someone a moderator</li>
            </ul>
        </main>
        <?php
    }
    ?>
</body>

</html>