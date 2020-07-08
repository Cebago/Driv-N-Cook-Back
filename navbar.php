<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if ($_SERVER["REQUEST_URI"] != '/home.php') { ?>
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Accueil</a>
                </li>
            <?php } ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="global" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Entreprise
                </a>
                <div class="dropdown-menu" aria-labelledby="global">
                    <a class="dropdown-item" href="franchisees.php">Gestion des franchisés</a>
                    <a class="dropdown-item" href="users.php">Gestion des utilisateurs</a>
                    <a class="dropdown-item" href="trucks.php">Gestion du parc de camions</a>
                    <a class="dropdown-item" href="warehouses.php">Liste des entrepôts</a>
                    <a class="dropdown-item" href="viewMessages.php">Demandes de contact</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="warehouses" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Approvisionnement
                </a>
                <div class="dropdown-menu" aria-labelledby="warehouses">
                    <a class="dropdown-item" href="warehouseStore.php">Stock actuel de chaque entrepôt</a>
                    <a class="dropdown-item" href="ingredients.php">Liste des ingrédients</a>
                    <a class="dropdown-item" href="ordersHistory.php">Historique d'approvisionnement</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="benefits" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Revenus
                </a>
                <div class="dropdown-menu" aria-labelledby="benefits">
                    <a class="dropdown-item" href="sales.php">Vue en temps réel</a>
                    <a class="dropdown-item" href="exportToPdf.php">Synthèse PDF</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="benefits" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Newsletter & Avantages
                </a>
                <div class="dropdown-menu" aria-labelledby="benefits">
                    <a class="dropdown-item" href="newNewsletter.php">Créer une nouvelle newsletter</a>
                    <a class="dropdown-item" href="allNewsletter.php">Consulter les newsletters</a>
                    <a class="dropdown-item" href="advantages.php">Consulter la liste des avantages</a>
                    <a class="dropdown-item" href="categories.php">Consulter la liste des catégories</a>
                </div>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0 dropdown">
            <a class="btn btn-dark my-2 my-sm-0" href="#" id="warehouses" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="far fa-user-circle"></i>&nbsp;Gérer mon compte
            </a>
            <div class="dropdown-menu dropdown-menu-lg-left" aria-labelledby="warehouses">
                <a class="dropdown-item" href="myProfile.php">Mon profil</a>
                <a class="dropdown-item" href="myPassword.php">Mot de passe</a>
                <a class="dropdown-item" href="functions/logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Déconnexion</a>
            </div>
        </div>
    </div>
    <div class="fixed-top">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4">
                <h5 class="text-white h4">Driv'n Cook - Administration</h5>
                <span class="text-muted"><a href="home.php" class="btn-dark">Accéder à l'accueil</a></span>
                <span class="text-muted">&nbsp;|&nbsp;</span>
                <span class="text-muted"><a href="myProfile.php" class="btn-dark">Mon profil</a></span>
                <span class="text-muted">&nbsp;|&nbsp;</span>
                <span class="text-muted"><a href="myPassword.php" class="btn-dark">Mot de passe</a></span>
                <span class="text-muted">&nbsp;|&nbsp;</span>
                <span class="text-muted"><a href="home.php" class="btn-dark">Se déconnecter</a></span>
            </div>
        </div>
        <nav class="navbar navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>
</nav>