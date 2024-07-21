<?php
require_once "config\BddManager.php";
require_once "classes/User.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$id = $_SESSION["user"]["id"];

$sql = $bdd->prepare("SELECT profilePicFileName, profilePicType, profilePicData FROM user WHERE id= :id");
$sql->bindParam(':id', $id);
$sql->execute();

header("Content-Type: image/jpeg");

$row = $sql->fetch(PDO::FETCH_ASSOC);
echo $row['data'];

$bddManager->disconnectBDD();