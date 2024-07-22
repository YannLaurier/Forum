<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();
$message="";

if(isset($_POST["SignUp"])){
    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $pass = htmlspecialchars($_POST["pass"]);
    $pass2 = htmlspecialchars($_POST["pass2"]);
    $email = htmlspecialchars($_POST["email"]);
    $email2 = htmlspecialchars($_POST["email2"]);

    if (!empty($pass) && !empty($pass2) && !empty($email) && !empty($email2)) {
        if ($pass === $pass2 && $email === $email2) {
            $pseudoCheck = User::comparePseudo($bdd, $pseudo);
            $emailCheck = User::compareEmail($bdd, $email);
            
            if($pseudoCheck === true){
                $message = "Pseudo déjà en usage, sois plus original (ou moins concis).";
            }elseif($emailCheck === true){
                $message = "C'est le mail de quelqu'un d'autre ça, inscris-toi avec le tien.";
            }else{
            $newUser = new User;
            $newUser->setPseudo($pseudo);
            $newUser->setEmail($email);
            $newUser->setPass(password_hash($pass, PASSWORD_BCRYPT));
            User::addUser($bdd, $newUser);
            header('Location: index.php');
            }
    }else{$message = "Assure-toi d'entrer deux fois le même mot de passe et deux fois le même email.";}
}else{
    $message ="Oups! Quelque chose était vide...";
}
}

$bddManager->disconnectBDD();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php"; ?>
    <main>
    <section class="flex container">
        <form action="" method="POST" class="flex column signForm">
            <div class="flex wrap between">
                <div class="bigInput">
                    <label for="pseudo">Pseudo:</label>
                    <input type="text" name="pseudo" id="pseudo">
                </div>
                <div class="miniInput">
                    <label for="pass">Mot de passe:</label>
                    <input type="password" name="pass" id="pass">
                </div>
                <div class="miniInput">
                    <label for="pass2">Confirmer mot de passe:</label>
                    <input type="password" name="pass2" id="pass">
                </div>
                <div class="miniInput">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email">
                </div>
                <div class="miniInput">
                    <label for="email2">Confirmer email:</label>
                    <input type="text" name="email2" id="email2">
                </div>
            </div>
            <p class="message"><?php echo $message; ?></p>
            <button type="submit" name="SignUp">S'inscrire</button>
        </form>
    </section>
    </main>
    <?php include "components/footer.php"; ?>
</body>

</html>