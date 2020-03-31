<?php
session_start();
include 'header.php';
require 'conf.inc.php';
require 'functions.php'; ?>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="card-deck w-75 mx-auto mt-5">
        <div class="card menu">
            <img src="https://www.humanprogresscenter.com/wp-content/uploads/2016/05/fond-gris.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Gestion de l'entreprise</h5>
                <ul class="list-group">
                    <a href="franchisees.php">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Gestion des franchisés
                            <span class="badge badge-primary badge-pill">
                                <?php
                                    $pdo = connectDB();
                                    $query = "SELECT COUNT(idUser) AS COUNT FROM USER, SITEROLE WHERE userRole = idRole AND roleName = 'Franchisé' ";
                                    $queryPrepared = $pdo->prepare($query);
                                    $result = $queryPrepared->execute();
                                    $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                                    echo $result[0]['COUNT'];
                                ?>
                            </span>
                        </li>
                    </a>
                    <a href="users.php">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Gestion des utilisateurs
                            <span class="badge badge-primary badge-pill">
                                <?php
                                    $pdo = connectDB();
                                    $query = "SELECT COUNT(idUser) AS COUNT FROM USER ;";
                                    $queryPrepared = $pdo->prepare($query);
                                    $result = $queryPrepared->execute();
                                    $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                                    echo $result[0]['COUNT'];
                                ?>
                            </span>
                        </li>
                    </a>
                    <a href="trucks.php">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Gestion du parc de camions
                            <span class="badge badge-primary badge-pill">
                                <?php
                                    $pdo = connectDB();
                                    $query = "SELECT COUNT(*) AS COUNT FROM TRUCK;";
                                    $queryPrepared = $pdo->prepare($query);
                                    $result = $queryPrepared->execute();
                                    $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                                    echo $result[0]['COUNT'];
                                ?>
                            </span>
                        </li>
                    </a>
                </ul>
            </div>
        </div>
        <div class="card menu">
            <img src="https://www.humanprogresscenter.com/wp-content/uploads/2016/05/fond-gris.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Approvisionnement</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-primary badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Dapibus ac facilisis in
                        <span class="badge badge-primary badge-pill">2</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Morbi leo risus
                        <span class="badge badge-primary badge-pill">1</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card menu">
            <img src="https://www.humanprogresscenter.com/wp-content/uploads/2016/05/fond-gris.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Revenus</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-primary badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Dapibus ac facilisis in
                        <span class="badge badge-primary badge-pill">2</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Morbi leo risus
                        <span class="badge badge-primary badge-pill">1</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

