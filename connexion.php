<?php 
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();
$message="";

if(isset($_POST["SignIn"])){
    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $pass = htmlspecialchars($_POST["pass"]);

    if (!empty($pseudo) && !empty($pass)) {
        $user = User::connectUser($bdd, $pseudo);
        if ($user) {
            $_SESSION["user"] = $user;
            header("Location: profil.php?pseudo=".$_SESSION["user"]["pseudo"]);
        }
    }
    header('Location: index.php');
}

$bddManager->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php" ?>
    <main>
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
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>