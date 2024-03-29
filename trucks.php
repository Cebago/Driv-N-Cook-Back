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

<?php
if (isset($_SESSION["errors"])) {
    echo "<div class='card alert alert-danger ml-2 mr-2 mt-5 mb-3'>";
    echo "<ul>";
    foreach ($_SESSION["errors"] as $error) {
        echo "<li>" . $error . "</li>";
    }
    echo "</ul>";
    echo "</div>";
    unset($_SESSION["errors"]);
}
?>


<div class="menu mt-5 card col-md-11 mx-auto">
    <h5 class="card-header">Gestion de l'ensemble des camions</h5>
    <div class="card-body">
        <button type="button" class="btn btn-primary ml-5 mr-5 mx-auto" data-toggle="modal"
                data-target="#createTruckModal"><i class="fas fa-plus"></i>&nbsp;Ajouter un nouveau camion
        </button>
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tabTrucksInfo" role="tab"
               aria-controls="home" aria-selected="true">Tableau</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tabmapAllTrucks" onclick="showMap()"
               role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-map-marked-alt"></i> Carte
                intéractive</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tabTrucksInfo" role="tabpanel" aria-labelledby="home-tab">
            <table class="table table-striped mt-2">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Marque</th>
                    <th scope="col">Modèle</th>
                    <th scope="col">Nom</th>
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
        <div class="tab-pane fade show" id="tabmapAllTrucks" role="tabpanel" aria-labelledby="home-tab">
            <div class="mapModal" id="mapAllTrucks"></div>
        </div>
    </div>

    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
                        <input type="text" id="assign" class="form-control truckID" name="idTruck" placeholder="idTruck"
                               aria-label="truckId" aria-describedby="addon-wrapping" readonly>
                    </div>
                    <select class="custom-select mt-2" name="user" id="select">
                        <option selected>Choisir un franchisé</option>
                        <?php
                        $pdo = connectDB();
                        $queryPrepared = $pdo->prepare("SELECT idUser, firstname, lastname FROM USER, SITEROLE WHERE userRole = idRole AND roleName = 'Franchisé';");
                        $queryPrepared->execute();
                        $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $value) {
                            $name = strtoupper($value["lastname"]) . " " . $value["firstname"];
                            echo "<option value='" . $value["idUser"] . "'>" . $name . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-primary" data-dismiss="modal" type="button" onclick="assignTruck()">
                        Assigner
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createTruckModal" tabindex="-1" role="dialog" aria-labelledby="createTruck"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTruck">Créer un camion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group flex-nowrap mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="manufacturers">Marque</span>
                        </div>
                        <input type="text" id="truckManufacturers" class="form-control" name="createTruckManufacturers"
                               placeholder="Marque du camion" aria-label="truckId" aria-describedby="addon-wrapping">
                    </div>
                    <div class="input-group flex-nowrap mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="model">Modèle</span>
                        </div>
                        <input type="text" id="truckModel" class="form-control" name="createTruckModel"
                               placeholder="Modèle du camion" aria-label="truckId" aria-describedby="addon-wrapping">
                    </div>
                    <div class="input-group flex-nowrap mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="name">Nom</span>
                        </div>
                        <input type="text" id="truckName" class="form-control" name="createTruckName"
                               placeholder="Nom du camion" aria-label="truckId" aria-describedby="addon-wrapping">
                    </div>
                    <div class="input-group flex-nowrap mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="name">Catégorie</span>
                        </div>
                        <input type="text" id="truckCategory" class="form-control" name="createTruckCategory"
                               placeholder="Catégorie du camion" aria-label="truckId" aria-describedby="addon-wrapping">
                    </div>
                    <div class="input-group flex-nowrap mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="plate">Plaque d'immatriculation</span>
                        </div>
                        <input type="text" id="licensePlate" class="form-control" name="createLicensePlate"
                               placeholder="Plaque d'immatriculation du camion" aria-label="truckId"
                               aria-describedby="addon-wrapping">
                    </div>
                    <small id="plateHelp" class="form-text text-muted">Merci de respecter les deux formats suivants:
                        AA-111-AA ou 111 AAA 11</small>
                    <div class="input-group flex-nowrap mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="km">Nombre de kilomètres</span>
                        </div>
                        <input type="number" id="truckKm" class="form-control" name="createTruckKm"
                               placeholder="Kilomètres parcourus" aria-label="truckId"
                               aria-describedby="addon-wrapping">
                    </div>
                    <div class="input-group mb-3 mt-1">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="truckWarehouse">Options</label>
                        </div>
                        <select class="custom-select" id="truckWarehouse">
                            <option selected>Choisir un entrepôt</option>
                            <<?php
                            $pdo = connectDB();
                            $queryPrepared = $pdo->prepare("SELECT idWarehouse, warehouseName FROM WAREHOUSES WHERE warehouseType = 'Entrepôt'");
                            $queryPrepared->execute();
                            $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $value) {
                                echo "<option value='" . $value["idWarehouse"] . "'>" . $value["warehouseName"] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-success" data-dismiss="modal" type="button" onclick="createTruck()">Créer le
                        camion
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateTruck" tabindex="-1" role="dialog" aria-labelledby="updateTruckInfo"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTruckInfo">Modifier le camion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="idTruck">Camion n°</span>
                        </div>
                        <input type="text" id="update" class="form-control truckID" name="idTruck" placeholder="idTruck"
                               aria-label="truckId" aria-describedby="addon-wrapping" readonly>
                    </div>
                    <div class="input-group flex-nowrap mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="truckManufacturers">Marque</span>
                        </div>
                        <input type="text" id="updateManufacturers" class="form-control truck" name="truckManufacturers"
                               placeholder="Marque du camion" aria-label="truckId" aria-describedby="addon-wrapping">
                    </div>
                    <div class="input-group flex-nowrap mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="truckModel">Modèle</span>
                        </div>
                        <input type="text" id="updateModel" class="form-control truck" name="truckModel"
                               placeholder="Modèle du camion" aria-label="truckId" aria-describedby="addon-wrapping">
                    </div>
                    <div class="input-group flex-nowrap mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="truckName">Nom</span>
                        </div>
                        <input type="text" id="updateName" class="form-control truck" name="truckName"
                               placeholder="Nom du camion" aria-label="truckId" aria-describedby="addon-wrapping">
                    </div>
                    <div class="input-group flex-nowrap mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="licensePlate">Plaque d'immatriculation</span>
                        </div>
                        <input type="text" id="updateLicense" class="form-control truck" name="licensePlate"
                               placeholder="Plaque d'immatriculation du camion" aria-label="truckId"
                               aria-describedby="addon-wrapping">
                    </div>
                    <small id="plateHelp" class="form-text text-muted">Merci de respecter les deux formats suivants:
                        AA-111-AA ou 111 AAA 11</small>
                    <div class="input-group flex-nowrap mt-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="km">Nombre de kilomètres</span>
                        </div>
                        <input type="number" id="updateKM" class="form-control truck" name="km"
                               placeholder="Kilomètres parcourus" aria-label="truckId"
                               aria-describedby="addon-wrapping">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-primary" data-dismiss="modal" type="button" onclick="updateTruck()">
                        Modifier
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="generalInfo" tabindex="-1" role="dialog" aria-labelledby="locateTruck"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTruckInfo">Informations générales du camion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="idTruck">Camion n°</span>
                        </div>
                        <input type="text" id="generalInfo" class="form-control truckID" name="idTruck"
                               placeholder="idTruck" aria-label="truckId" aria-describedby="addon-wrapping"
                               readonly="true">
                    </div>
                    <div class="mt-1">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#openDays" role="tab"
                                   aria-controls="home" aria-selected="true"><i class="fas fa-calendar-week"></i>&nbsp;Horaires</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#maintenance" role="tab"
                                   aria-controls="profile" aria-selected="false"><i class="fas fa-car-crash"></i>&nbsp;Incidents</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#map1Truck" role="tab"
                                   aria-controls="contact" aria-selected="false" id="map-tab"><i
                                            class="fas fa-map-marked-alt"></i>&nbsp;Localisation</a>
                            </li>
                        </ul>
                        <div class="tab-content card mt-1" id="myTabContent">
                            <div class="tab-pane fade show active" id="openDays" role="tabpanel"
                                 aria-labelledby="home-tab">
                                <table class="table" id="openTable">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Jour de la semaine</th>
                                        <th scope="col">Ouverture</th>
                                        <th scope="col">Fermeture</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="maintenance" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="col-md-11">
                                    <div id="truckStatus"></div>
                                    <div id="maintenanceContent" class="tab-content"></div>
                                    <div id="pagination" class="mt-3"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade mapModal" id="map1Truck" role="tabpanel"
                                 aria-labelledby="contact-tab"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="truckUpload" tabindex="-1" role="dialog" aria-labelledby="uploadImageLabel"
         aria-hidden="true">
        <form method="POST" action="./functions/uploadImageTruck.php" enctype="multipart/form-data">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadImageLabel">Ajouter un menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="truckID">Numéro du camion</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Numéro du camion" name="idTruck"
                                   id="idTruckUpload" readonly required aria-label="Username" aria-describedby="truckID">
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="truckImage"
                                       aria-describedby="inputGroupFileAddon01" required>
                                <label class="custom-file-label" for="inputGroupFile01">Choisir un fichier</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDr_vOUs3BJrToO67yuX8dmTYvr8qCbWB8&callback=initMap">
    </script>


    <?php
    include 'footer.php';
    ?>
    <script src="scripts/scripts.js"></script>