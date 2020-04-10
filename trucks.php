<?php
session_start();
include 'header.php';
require 'conf.inc.php';
require 'functions.php';
?>
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
        <tbody id="tablebody">
        
        </tbody>
    </table>
</div>
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
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
                <select class="custom-select mt-2" name="user" id="select">
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
                <button class="btn btn-primary" data-dismiss="modal" type="button" onclick="assignTruck()">Assigner</button>
            </div>
        </div>
    </div>
</div>
<script>
    function displayTruckId(idTruck) {
        const content = document.getElementById("assign");
        content.value = idTruck;
    }
    function unassignDriver(idtruck) {
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if(request.readyState === 4) {
                if(request.status === 200) {
                    //console.log(request.responseText);
                }
            }
        };
        request.open('POST', 'functions/unassignDriver.php');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(
            'truck=' + idtruck
        );
        refreshTable();
    }
    function assignTruck() {
        const truck = document.getElementById("assign").value;
        const user = document.getElementById("select").value;
        
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if(request.readyState === 4) {
                if(request.status === 200) {
                    if (request.responseText !== "") {
                        alert(request.responseText);
                    }
                }
            }
        };
        request.open('POST', 'functions/assignDriver.php');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(
            'user=' + user +
            "&truck=" + truck
        );
        refreshTable();
    }
    function refreshTable() {
        const content = document.getElementById("tablebody");
        
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if(request.readyState === 4) {
                if(request.status === 200) {
                    //console.log(request.responseText);
                    content.innerHTML = request.responseText;
                }
            }
        };
        request.open('GET', './functions/getTruckList.php', true);
        //request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send();
    }
    setInterval(refreshTable, 60000);
    window.onload = refreshTable;
</script>
<?php include "footer.php"; ?>
</body>