<?php
require_once "../config/BddManager.php";
require_once "../classes/User.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$thatGuy = User::bringOneUser($bdd, $_GET["id"]);

$id = $thatGuy["id"];


if(!empty($thatGuy["profilePicData"])){
$sql = $bdd->prepare("SELECT profilePicFileName, profilePicType, profilePicData FROM user WHERE id= :id");
$sql->bindParam(':id', $id);
$sql->execute();

header("Content-Type:".$thatGuy["profilePicType"]);

$row = $sql->fetch(PDO::FETCH_ASSOC);
echo $row['profilePicData'];

}

$bddManager->disconnectBDD();