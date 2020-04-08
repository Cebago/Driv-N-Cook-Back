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
                echo "<td class='table-secondary'>Aucun</td>";
            }
            echo "<td><button class='btn btn-primary' type='button' data-toggle='modal' data-target='#assignModal' data-whatever='" .
                $value["idTruck"] . "' onclick='displayTruck(". $value["idTruck"] . ")'><i class=\"fas fa-user-tag\"></i></button></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="functions/assignDriver.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assigner un conducteur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="idTruck">Camion n°</span>
                        </div>
                        <input type="text" id="assign" class="form-control" name="truck" placeholder="idTruck" aria-label="truckId" aria-describedby="addon-wrapping" readonly>
                    </div>
                    <select class="custom-select mt-2" name="user">
                        <option selected>Choisir un franchisé</option>
                        <?php
                            $pdo = connectDB();
                            $queryPrepared = $pdo->prepare("SELECT idUser, firstname FROM USER, SITEROLE WHERE userRole = idRole AND roleName = 'Franchisé';");
                            $queryPrepared->execute();
                            $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $value) {
                                echo "<option value='" . $value["idUser"] . "'>" . $value["firstname"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Assigner</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function displayTruck(idTruck) {
        const content = document.getElementById("assign");
        content.value = idTruck;
    }
</script>
<?php include "footer.php"; ?>
</body>