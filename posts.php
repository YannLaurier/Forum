<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";
require_once "classes\Post.php";
require_once "classes\Answer.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$posts = Post::bringPosts($bdd);

$postId = $_GET["id"];
settype($postId, "integer");

$ans = Answer::bringAns($bdd, $postId);

$message = "";

$bddManager->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    foreach ($posts as $tab) {
        if ($tab["id"] === $postId) {
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
                if ($tab["id"] === $postId) {
                    echo $tab["title"];

                    ?></h1>
                    <section><?php
                    echo $tab["content"];
                }
            }
            ?>
            </section>
            <section >
                <?php if (!empty($ans)) {
                foreach ($ans as $tab) { ?>
                <div class="answers flex list pad-10">
                <div class="flex column profile">
                <?php echo '<img src="uploads/' . $tab["Profile_pic"] . '" alt="profile pic of ' . $tab["Pseudo"] . '">';
            echo '<h3 class= ansPseudo pad-10"><a href="profil.php?pseudo='.$tab["Pseudo"].'">' . $tab["Pseudo"] . '</a></h3>'
                                    ?>
            </div>
            <?php
            echo '<p class="ansContent">' . $tab["content"] . '</p>';
            ?> </div> <?php
                }
                }else{
                    echo "<p class = 'thisEmptyMessage'>Personne n'a encore répondu à ce post. Veux-tu changer cela ?</p>";
                }
                ?>
            </section>
            <section>
                <form method="POST" action="actions/addAnswer.php" class="flex pad-10 gap-10">
                    <textarea type="text" name="AnsContent" placeholder="Tapez votre réponse ici..."></textarea>
                    <button class="tinyGuy" type="submit" name="addAnswer" value="<?php echo $postId; ?>">Répondre</button>
                </form>
            </section>
        </div>
    </main>
    <?php include "components/footer.php"; ?>
</body>

</html>