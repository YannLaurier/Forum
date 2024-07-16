<div id="nav" class="flex">
    <div id="navbar" class="flex container between">
        <ul class="flex">
            <li><a href="index.php">Accueil</a></li>
            <?php if (isset($_SESSION["user"])) {
                echo '<li><a href="logout.php">Déconnexion</a></li>';
                if($_SESSION["user"]["status"] == "admin"){
                    echo '<li><a href="admin.php">Dashboard</a></li>';
                }elseif($_SESSION["user"]["status"] == "modo"){
                    echo '<li><a href="modo.php">Dashboard</a></li>';
                }
            } else {
                echo '<li><a href="connexion.php">Connexion</a></li>
                      <li><a href="inscription.php">Inscription</a></li>';
            }
            ?>
        </ul>
        <div>
            <?php if(isset($_SESSION["user"])){echo '
            <p>Salut, <a href="profil.php">'.$_SESSION["user"]["Pseudo"].'</a></p>'; } ?>
        </div>
    </div>
</div>