<?php
session_start();
include 'header.php';
require 'conf.inc.php';
require 'functions.php'; ?>
</head>

<body>
<?php include "navbar.php"; ?>
<div class="menu mt-5 card col-md-11 mx-auto">
    <table class="table table-striped mt-2">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Marque</th>
            <th scope="col">Modèle</th>
            <th scope="col">Plaque d'immatriculation</th>
            <th scope="col">Distance parcourue</th>
            <th scope="col">Date de création</th>
            <th scope="col">Conducteur</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT * FROM pa2a2drivncook.TRUCK;");
        $queryPrepared->execute();
        $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $value) {
            echo "<tr>";
            echo "<th scope='row'>" . $value["idTruck"] . "</th>";
            echo "<td>" . $value["truckManufacturers"] . "</td>";
            echo "<td>" . $value["truckModel"] . "</td>";
            echo "<td>" . $value["licensePlate"] . "</td>";
            echo "<td>" . $value["km"] . "</td>";
            echo "<td>" . $value["createDate"] . "</td>";
            if (isset($value["user"])) {
                $pdo = connectDB();
                $queryPrepared = $pdo->prepare("SELECT firstname FROM USER WHERE idUser = :user");
                $queryPrepared->execute([
                    ":user" => $value["user"]
                ]);
                $user = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                echo "<td class='table-success'>" . $user[0]["firstname"] . "</td>";
            } else {
                echo "<td class='table-warning'>Aucun</td>";
            }
            echo "<td></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<?php include "footer.php"; ?>
</body>