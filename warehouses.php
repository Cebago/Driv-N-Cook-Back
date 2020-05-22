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
            <th scope="col">Nombre d'ingrédients différents</th>
            <th scope="col">Actions</th>
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
                        <span class="input-group-text" id="nameSpan">Nom de l'entrepôt</span>
                    </div>
                    <input type="text" class="form-control warehouse" id="warehouseName" placeholder="Nom de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="citySpan">Ville de l'entrpôt</span>
                    </div>
                    <input type="text" class="form-control warehouse" id="warehouseCity" placeholder="Ville de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addressSpan">Adresse de l'entrepôt</span>
                    </div>
                    <input type="text" class="form-control warehouse" id="warehouseAddress" placeholder="Adresse de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="postalCodeSpan">Code postal</span>
                    </div>
                    <input type="number" id="postalCode" class="form-control warehouse" id="warehousePostalCode" placeholder="Code postal" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button class="btn btn-primary" data-dismiss="modal" onclick="createWarehouse()" type="submit">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateWarehouse" tabindex="-1" role="dialog" aria-labelledby="updateWarehouse" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateWarehouseInfo">Modification d'un entrepôt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="updateName">ID de l'entrepôt</span>
                    </div>
                    <input type="text" class="form-control updateWarehouse" id="idWarehouse" name="idWarehouse" placeholder="ID de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping" readonly>
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="updateName">Nom de l'entrepôt</span>
                    </div>
                    <input type="text" class="form-control updateWarehouse" id="nameWarehouse" name="warehouseName" placeholder="Nom de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="updateCity">Ville de l'entrpôt</span>
                    </div>
                    <input type="text" class="form-control updateWarehouse" id="cityWarehouse" name="warehouseCity" placeholder="Ville de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="updateAddress">Adresse de l'entrepôt</span>
                    </div>
                    <input type="text" class="form-control updateWarehouse" id="addressWarehouse" name="warehouseAddress" placeholder="Adresse de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="updatePostalCode">Code postal</span>
                    </div>
                    <input type="number" id="warehouseZip" class="form-control updateWarehouse" name="warehousePostalCode" placeholder="Code postal" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button class="btn btn-primary" data-dismiss="modal" onclick="updateWarehouse()" type="submit">Modifier</button>
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
                        const td = document.createElement('td');
                        const updateButton = document.createElement('button');
                        updateButton.setAttribute('data-toggle', 'modal');
                        updateButton.setAttribute('data-target', '#updateWarehouse');
                        updateButton.setAttribute('data-whatever', myJson[i]["idWarehouse"]);
                        updateButton.className = "btn btn-info mr- mt-1";
                        updateButton.innerHTML = "<i class='fas fa-edit'></i>";
                        updateButton.type = "button";
                        updateButton.title = "Modifier les informations de l'entrepôt";
                        updateButton.setAttribute('onclick', "getInfo(" + myJson[i]['idWarehouse'] + ")");
                        td.appendChild(updateButton);
                        if (Number(myJson[i]["truck"]) === 0 && Number(myJson[i]["ingredients"]) === 0) {
                            const deleteButton = document.createElement('button');
                            deleteButton.className = "btn btn-info ml-1 mr-1 mt-1";
                            deleteButton.innerHTML = '<i class="fas fa-times"></i>';
                            deleteButton.type = "button";
                            deleteButton.title = "Supprimer l'entrepôt";
                            deleteButton.setAttribute('onclick', "deleteWarehouse(" + myJson[i]['idWarehouse'] + ")");
                            td.appendChild(deleteButton);
                        }
                        tr.appendChild(td);
                        content.appendChild(tr);

                    }
                }
            }
        };
        request.open('GET', './functions/getListWarehouses.php', true);
        request.send();
    }

    function createWarehouse() {
        let name = document.getElementById('warehouseName');
        let city = document.getElementById('warehouseCity');
        let address = document.getElementById('warehouseAddress');
        let postalCode = document.getElementById('postalCode');
        name = name.value;
        city = city.value;
        address = address.value;
        postalCode = postalCode.value;
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
        setTimeout(getListWarehouses, 1000);
    }

    function updateWarehouse() {
        const warehouse = document.getElementById("idWarehouse").value;
        const name = document.getElementById("nameWarehouse").value;
        const city = document.getElementById("cityWarehouse").value;
        const address = document.getElementById("addressWarehouse").value;
        const postalCode = document.getElementById("warehouseZip").value;
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
        request.open('POST', './functions/updateWarehouse.php', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(
            "id=" + warehouse
            + "&name=" + name
            + "&city=" + city
            + "&address=" + address
            + "&postalCode=" + postalCode
        );
        setTimeout(getListWarehouses, 1000);
    }

    function deleteWarehouse(id) {
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if(request.readyState === 4) {
                if(request.status === 200) {
                    if (request.responseText !== "") {
                        console.log(request.responseText);
                    }
                }
            }
        };
        request.open('POST', './functions/deleteWarehouse.php', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(
            "id=" + id
        );
        setTimeout(getListWarehouses, 1000);
    }
    
    function getInfo(idWarehouse) {
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if(request.readyState === 4) {
                if(request.status === 200) {
                    let myJson = JSON.parse(request.responseText);
                    const warehouse = document.getElementsByClassName("updateWarehouse");
                    for (let i = 0; i < warehouse.length; i++) {
                        const input = document.getElementsByName(warehouse[i].name);
                        input[0].value = myJson[0][warehouse[i].name];
                    }
                }
            }
        };
        request.open('GET', './functions/getWarehouseInfo.php?id='+idWarehouse, true);
        request.send();
    }
    

    window.onload = getListWarehouses;
    setInterval(getListWarehouses, 60000);
</script>

<?php include "footer.php"; ?>
</body>
