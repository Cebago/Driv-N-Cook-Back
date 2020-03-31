<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if ($_SERVER["REQUEST_URI"] != '/home.php') { ?>
            <li class="nav-item">
                <a class="nav-link" href="home.php">Accueil</a>
            </li>
            <?php } ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="global" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Entreprise
                </a>
                <div class="dropdown-menu" aria-labelledby="global">
                    <a class="dropdown-item" href="franchisees.php">Gestion des franchisés</a>
                    <a class="dropdown-item" href="users.php">Gestion des utilisateurs</a>
                    <a class="dropdown-item" href="#">Gestion du parc de camions</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="warehouses" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Approvisionnement
                </a>
                <div class="dropdown-menu" aria-labelledby="warehouses">
                    <a class="dropdown-item" href="#">Franchisé</a>
                    <a class="dropdown-item" href="#">Historique</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="benefits" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Revenus
                </a>
                <div class="dropdown-menu" aria-labelledby="benefits">
                    <a class="dropdown-item" href="#">Vue en temps réel</a>
                    <a class="dropdown-item" href="#">Historique</a>
                </div>
            </li>
        </ul>
    </div>
</nav>