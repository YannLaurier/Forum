<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";
require_once "classes\Post.php";
require_once "classes\Answer.php";
require_once "actions/displayProfilePic.php";

var_dump($_GET);
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?php echo $_SESSION["user"]["Pseudo"]; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php";
    ?>
    <main>
        <div class="container">
            <section id="user_info" class="flex between">
                <img src="actions/displayProfilePic.php?id=<?php echo $_SESSION['user']['id']; ?>" alt="profile picture">
                <button type="button" class="open">change profile pic</button>
                <dialog id="popover" class="pad-10" popover>
                    <form method = "POST" action="actions/editProfilePic.php" class="flex column miniInput" enctype="multipart/form-data">
                        <div class="flex">
                            <label for="newpp">New pic</label>
                            <input type="file" name="newPp" id="newPp">
                            <button type="button" class="close">
                            <svg fill="var(--dark)" xmlns="http://www.w3.org/2000/svg" width="17.828" height="17.828"><path d="m2.828 17.828 6.086-6.086L15 17.828 17.828 15l-6.086-6.086 6.086-6.086L15 0 8.914 6.086 2.828 0 0 2.828l6.085 6.086L0 15l2.828 2.828z"/></svg>
                            </button>
                        </div>
                        <button type="submit" name="editPp" value="<?php echo $_GET['pseudo']  ?>">Modifier</button>
                    </form>
                </dialog>
                <div class="flex column">
                    <button name="edit" id="edit">Edit profile</button>
                    <!-- when clicked that's meant to give you access to a pop-up form to add new profile pic, pseudo and/or email (update sql request that only changed the modified fields) - do w js script -->
                    <div class="text_right">
                        <h2><?php echo $_SESSION["user"]["Pseudo"]; ?></h2>
                        <p><?php echo $_SESSION["user"]["email"]; ?></p>
                    </div>
                </div>
            </section>
            <section id="recent_posts" class="flex column">
                <h2 class="text_right">Derniers posts</h2>
                <!--idk how but display only the like 5 most recent posts. Would probably fetch data w PHP then order w js ?
            Also text should be shortened after a certain max length, or maybe just display title w/ date, time, sous-cat ?-->
                <button class="tinyGuy">Voir tous</button>
            </section>
            <section id="recent_answers" class="flex column">
                <h2 class="text_right">Dernières réponses</h2>
                <!-- same method as above except it's going to be the answers - these don't have titles so def display : shortened text, date + time [maybe in relation to current date/time if you can do that in js ? maybe ?]-->
                <button class="tinyGuy">Voir tous</button>
            </section>
        </div>
    </main>
    <?php include "components/footer.php" ?>
</body>

<script src="js\popover.js"></script>
</html>