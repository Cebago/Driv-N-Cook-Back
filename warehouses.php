<?php
session_start();
require 'conf.inc.php';
require 'functions.php';

if (!isAdmin() || !isConnected()) {
    header("Location: login.php");
}

include 'header.php';
?>
<body>
<?php include 'navbar.php' ?>
<div class="menu mt-5 card col-md-11 mx-auto">
    <h5 class="card-header">Liste des camions</h5>
    <div class="card-body">
        <button type="button" class="btn btn-primary ml-5 mr-5 mx-auto" data-toggle="modal"
                data-target="#createWarehouse"><i class="fas fa-warehouse"></i>&nbsp;Ajouter un nouvel entrepôt
        </button>
    </div>
    <table class="table table-striped mt-2" id="tabWarehouses">
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
<div class="modal fade" id="createWarehouse" tabindex="-1" role="dialog" aria-labelledby="locateTruck"
     aria-hidden="true">
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
                    <input type="text" class="form-control warehouse" id="warehouseName" placeholder="Nom de l'entrepôt"
                           aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="citySpan">Ville de l'entrpôt</span>
                    </div>
                    <input type="text" class="form-control warehouse" id="warehouseCity"
                           placeholder="Ville de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addressSpan">Adresse de l'entrepôt</span>
                    </div>
                    <input type="text" class="form-control warehouse" id="warehouseAddress"
                           placeholder="Adresse de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="postalCodeSpan">Code postal</span>
                    </div>
                    <input type="number" id="postalCode" class="form-control warehouse" id="warehousePostalCode"
                           placeholder="Code postal" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button class="btn btn-primary" data-dismiss="modal" onclick="createWarehouse()" type="submit">Ajouter
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateWarehouse" tabindex="-1" role="dialog" aria-labelledby="updateWarehouse"
     aria-hidden="true">
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
                    <input type="text" class="form-control updateWarehouse" id="idWarehouse" name="idWarehouse"
                           placeholder="ID de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping"
                           readonly>
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="updateName">Nom de l'entrepôt</span>
                    </div>
                    <input type="text" class="form-control updateWarehouse" id="nameWarehouse" name="warehouseName"
                           placeholder="Nom de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="updateCity">Ville de l'entrpôt</span>
                    </div>
                    <input type="text" class="form-control updateWarehouse" id="cityWarehouse" name="warehouseCity"
                           placeholder="Ville de l'entrepôt" aria-label="warehouse" aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="updateAddress">Adresse de l'entrepôt</span>
                    </div>
                    <input type="text" class="form-control updateWarehouse" id="addressWarehouse"
                           name="warehouseAddress" placeholder="Adresse de l'entrepôt" aria-label="warehouse"
                           aria-describedby="addon-wrapping">
                </div>
                <div class="input-group flex-nowrap mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="updatePostalCode">Code postal</span>
                    </div>
                    <input type="number" id="warehouseZip" class="form-control updateWarehouse"
                           name="warehousePostalCode" placeholder="Code postal" aria-label="warehouse"
                           aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button class="btn btn-primary" data-dismiss="modal" onclick="updateWarehouse()" type="submit">
                    Modifier
                </button>
            </div>
        </div>
    </div>
</div>
<script>

</script>

<?php
include "footer.php";
?>

<script src="scripts/warehouses.js"></script>

