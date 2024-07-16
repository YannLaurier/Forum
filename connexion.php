<?php 
session_start();
require_once "config/config.php";

$bdd = new bdd();
$bdd->connectBDD();
$message="";

if(isset($_POST["SignIn"])){
    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $pass = htmlspecialchars($_POST["pass"]);

    if (!empty($pseudo) && !empty($pass)) {
        $user = $bdd->connectUser($pseudo);
        if ($user) {
            $_SESSION["user"] = $user;
            header("Location: profil.php");
        }
    }

    ;
    // header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "components/navbar.php" ?>
    <section class="flex container">
        <form action="" method="POST" class="flex column signForm">
            <div class="flex between">
                <div class="miniInput">
                    <label for="pseudo">Pseudonyme:</label>
                    <input type="text" name="pseudo" id="pseudo">
                </div>
                <div class="miniInput">
                    <label for="pass">Mot de passe:</label>
                    <input type="password" name="pass" id="pass">
                </div>
            </div>
            <p class="message"><?php echo $message; ?></p>
            <button type="submit" name="SignIn">Se connecter</button>
        </form>
    </section>
</body>

</html>