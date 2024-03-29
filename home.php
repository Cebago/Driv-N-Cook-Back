<?php
session_start();
require 'conf.inc.php';
require 'functions.php';

if (isAdmin() && isActivated() && isConnected()) {
include 'header.php';
?>

<body>
<?php include 'navbar.php'; ?>
<div class="card-deck w-75 mx-auto mt-5">
    <div class="card menu">
        <img src="https://www.humanprogresscenter.com/wp-content/uploads/2016/05/fond-gris.jpg" class="card-img-top"
             alt="...">
        <div class="card-body">
            <h5 class="card-title">Gestion de l'entreprise</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="franchisees.php" class="card-link">
                        Gestion des franchisés
                    </a>
                    <a class="badge badge-light badge-pill" href="franchisees.php">
                        <?php
                        $pdo = connectDB();
                        $query = "SELECT COUNT(idUser) AS COUNT FROM USER, SITEROLE WHERE userRole = idRole AND roleName = 'Franchisé' ";
                        $queryPrepared = $pdo->prepare($query);
                        $result = $queryPrepared->execute();
                        $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                        echo $result[0]['COUNT'];
                        ?>
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="users.php" class="card-link">
                        Gestion des utilisateurs
                    </a>
                    <a class="badge badge-light badge-pill" href="users.php">
                        <?php
                        $pdo = connectDB();
                        $query = "SELECT COUNT(idUser) AS COUNT FROM USER ;";
                        $queryPrepared = $pdo->prepare($query);
                        $result = $queryPrepared->execute();
                        $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                        echo $result[0]['COUNT'];
                        ?>
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="trucks.php" class="card-link">
                        Gestion du parc de camions
                    </a>
                    <a class="badge badge-light badge-pill" href="trucks.php">
                        <?php
                        $pdo = connectDB();
                        $query = "SELECT COUNT(*) AS COUNT FROM TRUCK;";
                        $queryPrepared = $pdo->prepare($query);
                        $result = $queryPrepared->execute();
                        $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                        echo $result[0]['COUNT'];
                        ?>
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="warehouses.php" class="card-link">
                        Liste des entrepôts
                    </a>
                    <a class="badge badge-light badge-pill" href="warehouses.php">
                        <?php
                        $pdo = connectDB();
                        $query = "SELECT COUNT(*) AS COUNT FROM WAREHOUSES WHERE warehouseType  = 'Entrepôt';";
                        $queryPrepared = $pdo->prepare($query);
                        $result = $queryPrepared->execute();
                        $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                        echo $result[0]['COUNT'];
                        ?>
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="viewMessages.php" class="card-link">
                        Demandes de contact
                    </a>
                    <a class="badge badge-light badge-pill" href="viewMessages.php">
                        <?php
                        $pdo = connectDB();
                        $query = "SELECT COUNT(idContact) as count FROM CONTACT WHERE isRead = false AND receiver is null";
                        $queryPrepared = $pdo->prepare($query);
                        $result = $queryPrepared->execute();
                        $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
                        echo $result['count'];
                        ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card menu">
        <img src="https://www.humanprogresscenter.com/wp-content/uploads/2016/05/fond-gris.jpg" class="card-img-top"
             alt="...">
        <div class="card-body">
            <h5 class="card-title">Approvisionnement</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="warehouseStore.php" class="card-link">
                        Stock actuel de chaque entrepôt
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="ingredients.php" class="card-link">
                        Liste des ingrédients
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="ordersHistory.php" class="card-link">
                        Historique d'approvisionnement
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card menu">
        <img src="https://www.humanprogresscenter.com/wp-content/uploads/2016/05/fond-gris.jpg" class="card-img-top"
             alt="...">
        <div class="card-body">
            <h5 class="card-title">Revenus</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="sales.php" class="card-link">
                        Vue en temps réel
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="exportToPdf.php" class="card-link">
                        Synthèse PDF
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card menu">
        <img src="https://www.humanprogresscenter.com/wp-content/uploads/2016/05/fond-gris.jpg" class="card-img-top"
             alt="...">
        <div class="card-body">
            <h5 class="card-title">Newsletter & Avantages</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="newNewsletter.php" class="card-link">
                        Créer une nouvelle newsletter
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="allNewsletter.php" class="card-link">
                        Consulter les newsletters
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="advantages.php" class="card-link">
                        Consulter la liste des avantages
                    </a>
                    <a class="badge badge-light badge-pill" href="advantages.php">
                        <?php
                        $pdo = connectDB();
                        $query = "SELECT COUNT(idAdvantage) as count FROM ADVANTAGE";
                        $queryPrepared = $pdo->prepare($query);
                        $result = $queryPrepared->execute();
                        $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
                        echo $result['count'];
                        ?>
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="categories.php" class="card-link">
                        Consulter la liste des catégories
                    </a>
                    <a class="badge badge-light badge-pill" href="categories.php">
                        <?php
                        $pdo = connectDB();
                        $query = "SELECT COUNT(idCategory) as count FROM PRODUCTCATEGORY";
                        $queryPrepared = $pdo->prepare($query);
                        $result = $queryPrepared->execute();
                        $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
                        echo $result['count'];
                        ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<?php
} else {
    header("Location: login.php");
}
?>
