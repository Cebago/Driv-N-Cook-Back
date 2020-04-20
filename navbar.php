<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
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
                    <a class="dropdown-item" href="trucks.php">Gestion du parc de camions</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="warehouses" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Approvisionnement
                </a>
                <div class="dropdown-menu" aria-labelledby="warehouses">
                    <a class="dropdown-item" href="warehouseStore.php">Stock actuel de chaque entrepôt</a>
                    <a class="dropdown-item" href="ordersFranchisees.php">Approvisionnement du franchisé</a>
                    <a class="dropdown-item" href="ordersHistory.php">Historique d'approvisionnement</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="benefits" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Revenus
                </a>
                <div class="dropdown-menu" aria-labelledby="benefits">
                    <a class="dropdown-item" href="sales.php">Vue en temps réel</a>
                    <a class="dropdown-item" href="salesHistory.php">Historique</a>
                </div>
            </li>
        </ul>
    </div>
</nav>