<?php
session_start();
require_once "config\BddManager.php";
require_once "classes\User.php";
require_once "classes\Answer.php";
require_once "classes\Post.php";
require_once "classes\Report.php";

$bddManager = new BddManager();
$bdd = $bddManager->connectBDD();

$pseudo = $_GET["pseudo"];

$thatGuy = User::bringOneUser($bdd, $pseudo);

$thatGuysPosts = Post::bringThatGuysPosts($bdd, $thatGuy["id"]);
$thatGuysAns = Answer::bringThatGuysAns($bdd, $thatGuy["id"]);
$thatGuysReports = Report::countReports($bdd, $thatGuy["id"]);

$bddManager->disconnectBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?php echo $_GET["pseudo"]; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex column between">
    <?php include "components/navbar.php";
    ?>
    <main>
        <div class="container">
            <section id="user_info" class="flex between">
                <img src=<?php
                if (!empty($thatGuy["profilePicData"])) {
                    echo "actions\displayProfilePic.php?id=".$pseudo;
                } else {
                    echo "assets/default.jpg";
                }
                ?> alt=<?php echo "profile picture of" . $thatGuy["Pseudo"]; ?>>
                <?php
                if (isset($_SESSION["user"])) {
                    if ($_SESSION["user"]["Pseudo"] === $_GET["pseudo"]) {
                        ?>
                        <button type='button' id='editPp' class='tinyGuy' data-toggle='modal' popovertarget='editProfilePic'>
                            <?php if (!empty($thatGuy["profilePicData"])) { ?>
                                <svg fill="var(--light)" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px"
                                    viewBox="0 0 568.017 568.017" xml:space="preserve">
                                    <path
                                        d="M72.553,400.503c11.12,11.119,29.156,11.119,40.282,0l71.849-83.238c11.12-11.119,7.387-20.141-8.342-20.141h-46.444 c-3.929-52.24,14.688-104.059,52.999-142.37c71.194-71.188,187.022-71.188,258.209,0c34.486,34.486,53.477,80.331,53.477,129.102 c0,48.77-18.996,94.616-53.477,129.102c-49.395,49.395-121.219,66.23-187.511,43.936c-19.205-6.488-40.043,3.867-46.512,23.09 c-6.469,19.223,3.868,40.043,23.09,46.512c27.124,9.131,54.903,13.574,82.388,13.574c66.623,0,131.439-26.156,180.461-75.184 c48.36-48.355,74.994-112.645,74.994-181.036c0-68.392-26.634-132.676-74.994-181.036c-99.823-99.823-262.243-99.823-362.06,0 c-52.424,52.424-78.636,122.871-74.75,194.304H14.744c-15.728,0-19.461,9.014-8.341,20.141L72.553,400.503z" />
                                </svg>
                                <?php
                            } else {
                                ?>
                                <svg fill="var(--light)" width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                    <g id="Page-1" stroke="none" stroke-width="1" fill-rule="evenodd" sketch:type="MSPage">
                                        <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                            transform="translate(-362.000000, -1037.000000)">
                                            <path
                                                d="M390,1049 L382,1049 L382,1041 C382,1038.79 380.209,1037 378,1037 C375.791,1037 374,1038.79 374,1041 L374,1049 L366,1049 C363.791,1049 362,1050.79 362,1053 C362,1055.21 363.791,1057 366,1057 L374,1057 L374,1065 C374,1067.21 375.791,1069 378,1069 C380.209,1069 382,1067.21 382,1065 L382,1057 L390,1057 C392.209,1057 394,1055.21 394,1053 C394,1050.79 392.209,1049 390,1049"
                                                id="plus" sketch:type="MSShapeGroup"></path>
                                        </g>
                                    </g>
                                </svg>
                                <?php
                            }
                            ?>
                        </button>
                        <dialog id="editProfilePic" class="pad-10 popover" popover>
                            <form method="POST" action="actions/editProfilePic.php" class="flex column bigInput"
                                enctype="multipart/form-data">
                                <div class="flex between">
                                    <input type="file" name="newPp" id="newPp">
                                    <button type="button" class="close">
                                        <svg fill="var(--dark)" xmlns="http://www.w3.org/2000/svg" width="17.828"
                                            height="17.828">
                                            <path
                                                d="m2.828 17.828 6.086-6.086L15 17.828 17.828 15l-6.086-6.086 6.086-6.086L15 0 8.914 6.086 2.828 0 0 2.828l6.085 6.086L0 15l2.828 2.828z" />
                                        </svg>
                                    </button>
                                </div>
                                <button type="submit" name="editPp" value="' . $_GET['pseudo'] . '">Confirmer</button>
                            </form>
                            <p class="thisEmptyMessage">Assure-toi que ton fichier est plus petit que 2Go, autrement il ne sera
                                pas uploadé !</p>
                        </dialog>
                        <?php
                    }
                }

                ?>
                <div class="flex column">
                    <?php
                    if (isset($_SESSION["user"])) {
                        if ($_SESSION["user"]["Pseudo"] === $thatGuy["Pseudo"]) { ?>
                            <button name="edit" id="edit" class='open' popovertarget="editProfileForm">Edit profile</button>
                            <dialog class="pad-10 popover" id="editProfileForm" aria-modal="true" popover>
                                <form method="POST" action="actions/editProfile.php" class="flex column">
                                    <div class="flex">
                                        <div class="miniInput">
                                            <label for="newPseudo">Change de pseudo : </label>
                                            <input type="text" name="newPseudo"
                                                value="<?php echo $_SESSION["user"]["Pseudo"]; ?>">
                                        </div>
                                        <div class="miniInput">
                                            <label for="newEmail">Change d'email :</label>
                                            <input type="email" name="newEmail"
                                                value="<?php echo $_SESSION["user"]["email"]; ?>">
                                        </div>
                                    </div>
                                    <label for="newDesc">Dis-nous en plus sur toi :</label>
                                    <textarea name="newDesc" id="newDesc"
                                        placeholder="Vous savez, moi je ne crois pas qu'il y ait de bonne ou de mauvaise situation. Moi, si je devais résumer ma vie aujourd'hui avec vous, je dirais que c'est d'abord des rencontres. Des gens qui m'ont tendu la main, peut-être...">
                                                                        <?php if (!empty($_SESSION["user"]["description"])) {
                                                                            echo $_SESSION["user"]["description"];
                                                                        }
                                                                        ; ?>
                                                                        </textarea>
                                    <div>
                                        <p>Montre-nous que c'est bien toi en entrant ton mot de passe actuel :</p>
                                        <input name="oldPword" type="password">
                                    </div>
                                    <button type="submit" name="editProfile"
                                        value="<?php echo $_SESSION["user"]["id"]; ?>">Confirmer les changements</button>
                                </form>
                            </dialog>
                        <?php }
                    } ?>
                    <div class="text_right">
                        <h2><?php echo $thatGuy["Pseudo"]; ?></h2>
                        <p><?php echo $thatGuy["email"]; ?></p>
                    </div>
                </div>
                <div>
                    <p>
                        <?php
                        if (!empty($thatGuy["description"])) {
                            echo $thatGuy["description"];
                        } else {
                            echo "<p class='thisEmptyMessage'>Cet utilisateur n'a pas encore entré d'informations complémentaires sur sa personne.</p>";
                        }
                        ?>
                    </p>
                </div>
                <?php
                if ($_SESSION["user"]["status"] === "admin" || $_SESSION["user"]["status"] === "modo") {
                    ?>
                    <p class="message pad-10 disclaimer"> Cet utilisateur a reporté
                        <?php echo $thatGuysReports[0]["COUNT(*)"]; ?> réponses et/ou posts de façon illégitime.
                    </p><?php
                }
                ?>
            </section>
            <section id="recent_posts">
                <h2 class="text_right">Derniers posts</h2>
                <?php
                foreach ($thatGuysPosts as $tab) {
                    ?>
                    <div class="list pad-10"><a
                            href="posts.php?id=<?php echo $tab["id"]; ?>"><?php echo $tab["title"]; ?></a></div>
                    <?php
                }
                ?>
            </section>
            <section id="recent_answers">
                <h2 class="text_right">Dernières réponses</h2>
                <?php
                foreach ($thatGuysAns as $tab) {
                    ?>
                    <div class="list pad-10"><a
                            href="posts.php?id=<?php echo $tab["FK_post_id"]; ?>"><?php echo substr($tab["content"], 0, 150); ?></a>
                    </div>
                    <?php
                }
                ?>
            </section>
        </div>
    </main>
    <?php include "components/footer.php"; ?>
</body>

</html>