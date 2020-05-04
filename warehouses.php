<?php
session_start();
require 'conf.inc.php';
require 'functions.php';
include "header.php";
?>
</head>
<body>
<?php include "navbar.php"; ?>
<div class="menu mt-5 card col-md-11 mx-auto">
    <h5 class="card-header">Liste des camions</h5>
    <div class="card-body">
        <button type="button" class="btn btn-primary ml-5 mr-5 mx-auto" data-toggle="modal" data-target="#createWarehouse"><i class="fas fa-warehouse"></i>&nbsp;Ajouter un nouvel entrepôt</button>
    </div>
    <table class="table table-striped mt-2">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nom</th>
            <th scope="col">Ville</th>
            <th scope="col">Adresse</th>
            <th scope="col">Code postal</th>
            <th scope="col">Camions</th>
        </tr>
        </thead>
        <tbody id="tablebody">
        </tbody>
    </table>
</div>
<div class="modal fade" id="createWarehouse" tabindex="-1" role="dialog" aria-labelledby="locateTruck" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTruckInfo">Ajout d'un nouvel entrepôt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="name">Nom de l'entrepôt</span>
                    </div>
                    <input type="text" class="form-control warehouse" name="warehouseName" placeholder="Nom de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="city">Ville de l'entrpôt</span>
                    </div>
                    <input type="text" id="warehouseCity" class="form-control warehouse" name="warehouseCity" placeholder="Ville de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="Address">Adresse de l'entrepôt</span>
                    </div>
                    <input type="text" id="warehouseAddress" class="form-control warehouse" name="warehouseAddress" placeholder="Adresse de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="km">Code postal</span>
                    </div>
                    <input type="number" id="postalCode" class="form-control warehouse" name="postalCode" placeholder="Code postal" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button class="btn btn-primary" type="submit" data-dismiss="modal" onclick="createWarehouse()">Ajouter</button>
            </div>
        </div>
    </div>
</div>
<script>
    function getListWarehouses() {
        const content = document.getElementById("tablebody");

        while (content.firstChild) {
            content.removeChild(content.firstChild);
        }

        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if(request.readyState === 4) {
                if(request.status === 200) {
                    let myJson = JSON.parse(request.responseText);
                    for (let i = 0; i < myJson.length; i++) {
                        const tr = document.createElement('tr');
                        const th = document.createElement('th');
                        th.scope = "row";
                        th.innerHTML = myJson[i]["idWarehouse"];
                        tr.appendChild(th);
                        const newJson = Object.keys(myJson[i]);
                        for (let j = 1; j < newJson.length; j++) {
                            this['td' + j] = document.createElement('td');
                            this['td' + j].innerHTML = myJson[i][newJson[j]];
                            tr.appendChild(this['td' + j]);
                        }
                        content.appendChild(tr);
                    }
                }
            }
        };
        request.open('GET', './functions/getListWarehouses.php', true);
        request.send();
    }

    function createWarehouse() {

        let name = document.getElementsByName('warehouseName');
        let city = document.getElementsByName('warehouseCity');
        let address = document.getElementsByName('warehouseAddress');
        let postalCode = document.getElementsByName('postalCode');

        name = name[0].value;
        city = city[0].value;
        address = address[0].value;
        postalCode = postalCode[0].value;

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
        request.open('POST', './functions/createWarehouse.php', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send("name=" + name
            + "&city=" + city
            + "&address=" + address
            + "&postalCode=" + postalCode
        );
        getListWarehouses();
    }

    window.onload = getListWarehouses;
</script>

<?php include "footer.php"; ?>
</body>
