<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";
require_once "classes\Post.php";
require_once "classes\Answer.php";
require_once "classes\Cat.php";
require_once "classes\Subcat.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$postId = $_GET["id"];
settype($postId, "integer");

$count = Answer::countAns($bdd, $postId);
if(!empty($count)){
    $nbAns = $count[0]["COUNT(*)"];
}else{
    $nbAns = 0;
}


$ansPerPage = 5;

$nbPages = ceil($nbAns / $ansPerPage);

if(isset($_GET["page"])){
    $currentPage = intval($_GET["page"]);
    if($currentPage > $nbPages){
        $currentPage = $nbPages;
    }
}else{
    $currentPage = 1;
}


$firstEntry = ($currentPage -1) * $ansPerPage;

$ans = Answer::bringAns($bdd, $postId, $firstEntry, $ansPerPage);

$post = Post::bringOnePost($bdd, $postId);
$thatSubCat = Subcat::bringOneSubCat($bdd, $post["FK_category_id"]);
$thatCat = Cat::bringOneCat($bdd,$thatSubCat["FK_mother_cat"]);

$message = "";

$bddManager->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    echo $post["postTitle"];
    ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php" ?>
    <main>
        <div class="container">
            <p class="thisEmptyMessage">
                Vous êtes ici :
                <a href="index.php">Accueil</a>
                >
                <a href="cat.php?id=<?php echo $thatCat["id"]; ?>"><?php echo $thatCat["title"]; ?></a>
                >
                <a href="subcat.php?id=<?php echo $thatSubCat["id"]; ?>"><?php echo $thatSubCat["title"]; ?></a>
                >
                <a href="posts.php?id=<?php echo $post["postId"] ?>"><?php echo $post["postTitle"] ?></a>
            </p>
            <section>
                <h1 class="pad-10">
                    <?php echo $post["postTitle"]; ?>
                </h1>
                <?php
                if (isset($_SESSION["user"])) { ?>
                    <div class="deletePost flex gap-10">
                        <button type="button" class="report" popovertarget="reportPost">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.15"
                                    d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                    fill="var(--red)" />
                                <path
                                    d="M12 16.99V17M12 7V14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                    stroke="var(--red)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <dialog popover id="reportPost" class="miniInput miniModal">
                            <div class="pad-10">
                                <form action="actions/addReport.php" method="POST" class="flex column">
                                    <div class="pad-10 gap-10 flex column ansPseudo">
                                        <label for="reason">Pourquoi veux-tu reporter ce post ?</label>
                                        <select name="reason" id="reason" required>
                                            <option value="haine personnelle">Je n'aime pas cette personne</option>
                                            <option value="contenu discriminatoire ou violent">Ce contenu est violent,
                                                discriminatoire ou haineux</option>
                                            <option value="incapacité à lire">Je ne sais pas lire</option>
                                            <option value="doublon">Ce topic fait doublon avec un ou plusieurs autres
                                            </option>
                                            <option value="autre">Autre raison (préciser)</option>
                                        </select>
                                    </div>
                                    <input type="text" name="details"
                                        placeholder="Donne-nous plus de détails sur ton report (optionnel)">
                                    <button type="submit" name="reportPost"
                                        value="<?php echo $post["postId"] ?>">Reporter</button>
                                </form>
                            </div>
                        </dialog>
                        <?php
                        if ($_SESSION["user"]["status"] === "admin" || $_SESSION["user"]["status"] === "modo" || $_SESSION["user"]["id"] === $post["FK_author_id"]) {
                            ?>
                            <?php if ($_SESSION["user"]["id"] === $post["FK_author_id"]) { ?>
                                <button class="tinyGuy open" type="button" popovertarget="editPost"
                                    value="<?php echo $post["postId"]; ?>">Modifier</button>
                                <dialog id="popover" class="pad-10" popover>
                                    <form action="actions/editPost.php" method="POST">
                                        <div class="flex">
                                            <input type="text" name="title" placeholder="Titre du sujet"
                                                value="<?php echo $post["postTitle"]; ?>">
                                            <button type="button" class="close">
                                                <svg fill="var(--dark)" xmlns="http://www.w3.org/2000/svg" width="17.828"
                                                    height="17.828">
                                                    <path
                                                        d="m2.828 17.828 6.086-6.086L15 17.828 17.828 15l-6.086-6.086 6.086-6.086L15 0 8.914 6.086 2.828 0 0 2.828l6.085 6.086L0 15l2.828 2.828z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <textarea name="content"><?php echo $post["content"]; ?></textarea>
                                        <button type="submit" name="editPost"
                                            value="<?php echo $post["postId"]; ?>">Modifier</button>
                                    </form>
                                </dialog>
                            <?php } ?>
                            <form action="actions/deletePost.php" method="POST">
                                <input type="hidden" name="subCat" value="<?php echo $post["FK_category_id"]; ?>">
                                <button class="tinyGuy" type="submit" name="deletePost"
                                    value="<?php echo $post["postId"]; ?>">Supprimer</button>
                            </form>
                            <?php
                        }
                }
                ?>
                </div>
                <p class="thisEmptyMessage">Publié le <?php
                $date = strtotime($post["publication_date"]);
                setlocale(LC_TIME, 'fr_FR');
                date_default_timezone_set('Europe/Paris');
                echo date("d F Y", $date) . " à " . date("h:i", $date);
                ?>
                </p>
                <div class="flex between">
                    <div class="flex column">
                        <img class="pad-10" src="<?php
                        if (!empty($post["profilePicData"])) {
                            echo "actions\displayProfilePic.php?id=" . $post["Pseudo"];
                        } else {
                            echo "assets/default.jpg";
                        }
                        ?>" alt="profile pic of <?php echo $post["Pseudo"] ?>">
                        <h2 class="pad-10 ansPseudo"><?php echo $post["Pseudo"]; ?></h2>
                    </div>
                    <p class="pad-10" style="width: 80%;">
                        <?php echo $post["content"]; ?>
                    </p>
                </div>
            </section>
            <section>
                <?php if (!empty($ans)) {
                    foreach ($ans as $key => $tab) {
                        ?>
                        <div class="answers flex list pad-10" name="answer" id="ans<?php echo $tab["answerId"]; ?>">
                            <div class="flex column profile">
                                <img src=<?php
                                if (!empty($tab["profilePicData"])) {
                                    echo "actions\displayProfilePic.php?id=" . $tab["Pseudo"];
                                } else {
                                    echo "assets/default.jpg";
                                }
                                ?>
                                    alt="profile picture of <?php $tab["Pseudo"] ?>">
                                <h3 class=ansPseudo pad-10"><a href="profil.php?pseudo=<?php
                                echo $tab["Pseudo"] ?>"><?php echo $tab["Pseudo"]; ?></a></h3>
                                <p class="thisEmptyMessage">Le <?php
                                $dateAns = strtotime($tab["time"]);
                                echo date("d F Y", $dateAns) . " à " . date("h:i", $dateAns); ?></p>
                            </div>
                            <div class="flex between ansBody">
                                <p class="ansContent pad-10"><?php echo $tab["content"] ?></p>
                                <div class="flex gap-10 ansForm">
                                    <button type="button" class="report" popovertarget="reportAns">
                                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.15"
                                                d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                                fill="var(--red)" />
                                            <path
                                                d="M12 16.99V17M12 7V14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                                stroke="var(--red)" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                    <dialog popover id="reportAns" class="miniInput miniModal">
                                        <div class="pad-10">
                                            <form action="actions/addReport.php" method="POST" class="flex column">
                                                <div class="pad-10 gap-10 flex column ansPseudo">
                                                    <label for="reason">Pourquoi veux-tu reporter cette réponse ?</label>
                                                    <select name="reason" id="reason" required>
                                                        <option value="haine personnelle">Je n'aime pas cette personne</option>
                                                        <option value="contenu discriminatoire ou violent">Ce contenu est
                                                            violent, discriminatoire ou haineux</option>
                                                        <option value="incapacité à lire">Je ne sais pas lire</option>
                                                        <option value="doublon">Cette réponse n'est pas pertinente par rapport
                                                            au topic</option>
                                                        <option value="autre">Autre raison (préciser)</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="postId" value="<?php echo $_GET["id"]; ?>">
                                                <input type="text" name="details"
                                                    placeholder="Donne-nous plus de détails sur ton report (optionnel)">
                                                <button type="submit" name="reportAns"
                                                    value="<?php echo $tab["answerId"]; ?>">Reporter</button>
                                            </form>
                                        </div>
                                    </dialog>
                                    <?php
                                    $baby = array_key_last($ans);
                                    if ($key === $baby && $tab["userId"] === $_SESSION["user"]["id"]) {
                                        ?>
                                        <button type="button" popovertarget="ModifAns<?php echo $tab["answerId"] ?>"
                                            class="tinyGuy">Modifier</button>
                                        <form action="actions/deleteAnswer.php" method="POST">
                                            <input type="hidden" name="postId" value="<?php echo $_GET["id"] ?>">
                                            <button type="submit" name="DeleteAns" value="<?php echo $tab["answerId"] ?>"
                                                class="tinyGuy">Supprimer</button>
                                        </form>
                                        <dialog id="ModifAns<?php echo $tab["answerId"] ?>" popover aria-modal="true">
                                            <form action="actions/editAnswer.php" method="POST" class="flex column">
                                                <input type="hidden" name="postId" value="<?php echo $_GET["id"] ?>">
                                                <textarea class="pad-10" name="newContent"><?php echo $tab["content"]; ?></textarea>
                                                <button class="pad-10" type="submit" name="editAns" class="tinyGuy"
                                                    value="<?php echo $tab["answerId"]; ?>">Modifier</button>
                                            </form>
                                        </dialog>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div> <?php
                    }
                } else {
                    echo "<p class = 'thisEmptyMessage'>Personne n'a encore répondu à ce post. Veux-tu changer cela ?</p>";
                }
                ?>
                <p class="thisEmptyMessage"><?php
                for($i =1; $i <= $nbPages; $i++){
                    if($i == $currentPage){
                        echo "[".$i."]";
                    }else{
                        ?>
                        <a href="posts.php?id=<?php echo $post['postId'];?>&page=<?php echo $i;?>"><?php echo $i; ?></a>
                        <?php
                    }
                }
                ?></p>
            </section>
            <section>
                <form method="POST" action="actions/addAnswer.php" class="flex pad-10 gap-10">
                    <textarea type="text" name="AnsContent" placeholder="Tapez votre réponse ici..."></textarea>
                    <button class="tinyGuy" type="submit" name="addAnswer"
                        value="<?php echo $postId; ?>">Répondre</button>
                </form>
            </section>
        </div>
    </main>
    <?php include "components/footer.php"; ?>
</body>

<script type="text/javascript" src="js\popover.js"></script>

</html>