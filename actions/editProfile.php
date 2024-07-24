<?php
session_start();

require_once "../config/BddManager.php";
require_once "../classes/User.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$emailCheck = false;
$pseudoCheck = false;

$thatGuy = User::bringOneUser($bdd, $_SESSION["user"]["Pseudo"]);

if (isset($_POST["editProfile"])) {
    $pseudo = htmlspecialchars($_POST["newPseudo"]);
    $pass = htmlspecialchars($_POST["oldPword"]);
    $description = htmlspecialchars($_POST["newDesc"]);
    $email = htmlspecialchars($_POST["newEmail"]);
    $id = htmlspecialchars($_POST["editProfile"]);

    echo $pseudo . '<br>' . $pass . '<br>' . $description . '<br>' . $email . '<br>' . $id;

    if (!empty($pass) && !empty($pseudo) && !empty($email) && !empty($description)) {
        echo "<br>I'm working FINE, MOM<br>";
        if (password_verify($pass, $_SESSION["user"]["Pass"]) === true) {
            if ($email !== $thatGuy["email"]) {
                $emailCheck = User::compareEmail($bdd, $email);
            }

            if ($pseudo !== $thatGuy["Pseudo"]) {
                $pseudoCheck = User::comparePseudo($bdd, $pseudo);
            }

            if ($pseudoCheck === false && $emailCheck === false){
                User::updateUser($bdd, $pseudo, $description, $email, $id);
                $_SESSION["user"]["Pseudo"] = $pseudo;
            }
        }
    }
}


$bddManager->disconnectBDD();
header('Location:../profil.php?pseudo='.$_SESSION["user"]["Pseudo"].'');