<?php
session_start()

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
                <img src="uploads/<?php echo $_SESSION["user"]["Profile_pic"]; ?>" alt="profile picture">
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
                <!--idk how but display only the like 5 most recent posts. Would probably fetch data w PHP then order w js ? [gridjs table type plugin maybe ? but like find a better one iykyk]
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

</html>