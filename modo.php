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
    } elseif ($_SESSION["user"]["status"] !== 'modo') {
        echo "<p class= 'message'>Oops ! You're not allowed to be there. Please depart.</p>";
    } else {
        ?>
        <main class="container">
            <h1>Moderator Dashboard</h1>
            <p>Moderator has access to all categories and they can :</p>
            <!-- I did the DB yesterday, didn't think of what moderators would actually *do*, and I suspect making moderators for specific categories would require an intermediary table which I really do not want to be adding so moderators have a bit too big of an interaction span with the forum -->
            <ul>
                <li>Create subcategory</li>
                <li>Delete subcategory</li>
                <li>Delete topic</li>
                <li>Delete answer</li>
            </ul>
        </main>
        <?php
    }
    ?>
</body>

</html>