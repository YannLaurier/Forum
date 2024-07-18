<?php
session_start();
require_once "classes/user.php";

$bdd = new bdd();
$bdd->connectBDD();

$posts = $bdd->bringPosts();
$users = $bdd->bringUsers();

$num = $_GET["id"];
settype($num, "integer");


$bdd->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    foreach ($posts as $tab) {
        if ($tab["id"] === $num) {
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
            foreach ($posts as $tab) {
                if ($tab["id"] === $num) {
                    echo $tab["title"];

                    ?></h1>
                    <section><?php
                    echo $tab["content"];
                }
            }
            ?>
            </section>
            <section>
                <!-- <div class="list flex">
                    <div class="flex column">
                        <?php 
//                     foreach($users as $tab){
//                         if($user["id"] === )
//                         echo '<img src="uploads/'.$tab["Profile_pic"].'" alt="profile pic of '.$tab["Pseudo"].'">';
//                         echo '<p>'.$tab["Pseudo"].'</p>'
//                     ?></div>
//                     <?php
//                     echo '<p>'.$tab["content"].'</p>';
// }
                    ?>
                </div> -->
                <form method="POST" action="actions/addAnswer.php" class="flex pad-10 gap-10">
                    <textarea type="text" name="AnsContent" placeholder="Tapez votre réponse ici..."></textarea>
                    <button class="tinyGuy" type="submit" name="addAnswer" value="<?php echo $num ?>">Répondre</button>
                </form>
                </section>
                
        </div>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>