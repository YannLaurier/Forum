<div class="flex dark_section">
    <div id="nav" class="flex container between">
        <div class="flex">
                <svg width="50px" height="50px" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M209.202 314C295.069 302.118 353.793 218.418 308.045 135.024C251.513 31.9842 61.8269 106.438 76.8437 219.371C86.6957 293.444 213.097 315.568 234.512 236.857C238.297 222.936 236.714 157.821 218.141 153.168C216.406 152.73 194.202 175.825 184.417 175.825C176.731 175.825 159.616 137.959 141.484 175.825"
                        stroke="var(--light)" stroke-opacity="0.9" stroke-width="20" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            <ul class="flex gap-10 pad-10">
                <li><a href="index.php">Accueil</a></li>
                <?php if (isset($_SESSION["user"])) {
                    echo '<li><a href="actions\logout.php">Déconnexion</a></li>';
                    if ($_SESSION["user"]["status"] == "admin" || $_SESSION["user"]["status"] == "modo") {
                        echo '<li><a href="dashboard.php">Dashboard</a></li>';
                    }
                } else {
                    echo '<li><a href="connexion.php">Connexion</a></li>
                      <li><a href="inscription.php">Inscription</a></li>';
                }
                ?>
            </ul>
        </div>
        <div>
            <?php if (isset($_SESSION["user"])) {
                echo '
            <p class=" pad-10">Salut, <a href="profil.php?pseudo=' . $_SESSION["user"]["Pseudo"] . '">' . $_SESSION["user"]["Pseudo"] . '</a></p>';
            } ?>
        </div>
    </div>
</div>