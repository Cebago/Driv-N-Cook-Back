<?php
session_start();
include 'header.php';
require 'conf.inc.php';
require 'functions.php'; ?>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="menu card mt-2 col-11 mx-auto mt-5">
        <table class="table table-striped mt-2">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Email</th>
                <th scope="col">Numéro</th>
                <th scope="col">Date de création</th>
                <th scope="col">Activation</th>
                <th scope="col">Adresse</th>
                <th scope="col">Code postal</th>
                <th scope="col">Permis n°</th>
                <th scope="col">Role</th>
                <th scope="col">Carte de fidélité</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $pdo = connectDB();
            $queryPrepared = $pdo->prepare("SELECT idUser, lastname, firstname, emailAddress, phoneNumber, 
                                                    DATE_FORMAT(createDate,'%d/%m/%Y') as createDate,
                                                    isActivated, address, postalCode, licenseNumber, roleName, fidelityCard 
                                                    FROM USER, SITEROLE 
                                                    WHERE idRole = userRole 
                                                    ORDER BY idUser");
            $queryPrepared->execute();
            $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $value) {
                echo "<tr>";
                echo "<th scope='row'>" . $value["idUser"] . "</th>";
                echo "<td>" . $value["lastname"] . "</td>";
                echo "<td>" . $value["firstname"] . "</td>";
                echo "<td>" . $value["emailAddress"] . "</td>";
                echo "<td>" . $value["phoneNumber"] . "</td>";
                echo "<td>" . $value["createDate"] . "</td>";
                if ($value["isActivated"]) {
                    echo "<td class='table-success'>Activé</td>";
                } else {
                    echo "<td class='table-warning'>En attente d'activation</td>";
                }
                echo "<td>" . $value["address"] . "</td>";
                echo "<td>" . $value["postalCode"] . "</td>";
                echo "<td>" . $value["licenseNumber"] . "</td>";
                echo "<td>" . $value["roleName"] . "</td>";
                echo "<td>" . $value["fidelityCard"] . "</td>";
                echo "<td></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php include "footer.php"; ?>
</body>