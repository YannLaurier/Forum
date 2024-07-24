<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\Report.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$count = Report::countReports($bdd);
if(!empty($count)){
    $nbReports = $count[0]["COUNT(*)"];
}else{
    $nbReports = 0;
}


$reportPerPage = 3;

$nbPages = ceil($nbReports / $reportPerPage);

if (isset($_GET["page"])) {
    $currentPage = intval($_GET["page"]);
    if ($currentPage > $nbPages) {
        $currentPage = $nbPages;
    }
} else {
    $currentPage = 1;
}

$firstEntry = ($currentPage - 1) * $reportPerPage;

$allReports = Report::bringAllReports($bdd, $firstEntry, $reportPerPage);

$bddManager->disconnectBDD();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des reports</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include "components/navbar.php";
    if (!isset($_SESSION["user"])) {
        echo "<section><p class= 'message'>Oops ! Il semble que tu ne sois pas connecté. Connecte-toi et réessaie.</p></section>";
    } elseif ($_SESSION["user"]["status"] !== 'admin' && $_SESSION["user"]["status"] !== 'modo') {
        echo "<section><p class= 'message'>Oops ! Tu n'es pas autorisé à être ici. Dégage.</p></session>";
    } else {
        ?>
        <main>
            <div class="container pad-10">
                <h1>Gestion des signalements</h1>
                <p class="thisEmptyMessage">Tu es ici : <a href="index.php">Accueil</a>
    > <a href="dashboard.php">Dashboard</a> >
    <a href="reportsGestion.php">Gestion des signalements</a>    
    </p>
                <section>
                    <div>
                        <?php foreach ($allReports as $tab) {
                            ?>
                            <div class="flex between list">
                                <div class="pad-10">
                                    <h2>Report n° #<?php echo $tab["reportId"]; ?></h2>
                                    <p class="pad-10"><?php
                                    if (!empty($tab["FK_id_answer"])) {
                                        echo "<a href=posts.php?id=" . $tab["postId"] . "#ans" . $tab["FK_id_answer"] . ">Cette réponse</a> a été reportée par <a href='profil.php?pseudo=" . $tab["reporterPseudo"] . "'>" . $tab["reporterPseudo"];
                                    } else {
                                        echo "<a href=posts.php?id=" . $tab["postId"] . ">Ce post </a> a été reporté par <a href='profil.php?pseudo=" . $tab["reporterPseudo"] . "'>" . $tab["reporterPseudo"];
                                    }
                                    ?>
                                        </a> pour la raison : <?php echo $tab["reason"]; ?></p>
                                    <p><?php
                                    if (!empty($tab["details"])) {
                                        echo "<span class='bold'>L'utilisateur a fourni les détails suivants : </span>" . $tab["details"];
                                    } else {
                                        echo "L'utilisateur n'a pas fourni de détails complémentaires.";
                                    }
                                    ?></p>
                                    <p class="pad-10"><span class="bold">Contenu incriminé :</span></p>
                                    <p>
                                        <?php
                                        if (!empty($tab["answerContent"])) {
                                            echo $tab["answerContent"];
                                        } else {
                                            echo $tab["postContent"];
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="flex column" style="width: 80px;">
                                    <form method="POST" action=<?php if (!empty($tab["FK_id_answer"])) {
                                        echo '"actions/deleteAnswer.php"';
                                        ?>>
                                            <button class=" tinyGuy" type="submit" name="DeleteAns"
                                                value="<?php echo $tab["FK_id_answer"]; ?>">Supprimer contenu</button>
                                            <?php
                                    } else {
                                        echo '"actions/deletePost.php"';
                                        ?>>
                                            <button class="tinyGuy" type="submit" name="deletePost"
                                                value="<?php echo $tab["FK_id_post"]; ?>">Supprimer contenu</button>
                                            <?php
                                    }
                                    ?>
                                    </form>
                                    <form method="POST" action="actions/deleteReport.php" style="margin-top : 10px;">
                                        <button class="tinyGuy" type="submit" name="deleteReport"
                                            value="<?php echo $tab["reportId"]; ?>">Ignorer Report</button>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <p class="thisEmptyMessage"><?php
                    for ($i = 1; $i <= $nbPages; $i++) {
                        if ($i == $currentPage) {
                            echo "[" . $i . "]";
                        } else {
                            ?>
                                <a href="reportsGestion.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                <?php
                        }
                    } ?>
                    </p>
                </section>
            </div>
        </main>
    <?php }
    include "components/footer.php"; ?>
</body>

</html>