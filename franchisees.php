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
<div class="menu mt-5 card col-md-11 mx-auto" >
    <h5 class="card-header">Gestion de l'ensemble des franchisés</h5>
    <table class="table table-striped mt-2" id="tableUser">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Date d'entrée dans la société</th>
            <th scope="col">Somme versée</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody id="tablebody"></tbody>
    </table>
</div>

<div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="priceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Consulter le solde d'un franchisé</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="identity">Franchisé</span>
                    </div>
                    <input type="text" id="assign" class="form-control Franchise" name="idTruck" placeholder="idTruck"
                           aria-label="truckId" aria-describedby="addon-wrapping" readonly>
                </div>
                <div id="franchisee"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="priceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assigner un conducteur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="identity">Franchisé</span>
                    </div>
                    <input type="text" id="franchiseeName" class="form-control Franchise" name="franchiseeName"
                           placeholder="franchiseeName" aria-label="franchiseeName" aria-describedby="addon-wrapping"
                           readonly>
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="sum">Somme</span>
                    </div>
                    <input type="number" id="price" class="form-control" name="price" placeholder="Somme versée"
                           aria-label="price" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="priceAdd" data-dismiss="modal">Valider le versement</button>
            </div>
        </div>
    </div>
</div>




<?php
include 'footer.php';
?>
<script src="scripts/franchises.js"></script>
<script>
    window.onload = getFranchisesList;
    setInterval(getFranchisesList, 60000);

</script>