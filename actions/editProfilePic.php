<?php
session_start();
require_once "../config/BddManager.php";
require_once "../classes/User.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

   if(isset($_FILES['newPp']) && $_FILES['newPp']['error'] == 0) {
      $name = $_FILES['newPp']['name'];
      $type = $_FILES['newPp']['type'];
      $data = file_get_contents($_FILES['newPp']['tmp_name']);
      $id = $_SESSION["user"]["id"];

      User::editProfilePic($bdd, $name, $type, $data, $id);
   }

$bddManager->disconnectBDD();
header('Location:../profil.php?pseudo='.$_SESSION["user"]["Pseudo"] .'');