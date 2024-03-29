<?php
session_start();
require "../conf.inc.php";
require "../functions.php";

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT idTruck, truckManufacturers, truckModel, truckName, licensePlate, km, DATE_FORMAT(createDate,'%d/%m/%Y') as createDate, user FROM pa2a2drivncook.TRUCK;");
$queryPrepared->execute();
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
$string = "";
foreach ($result as $value) {
    $string .= "<tr>";
    $string .= "<th scope='row'>" . $value["idTruck"] . "</th>";
    $string .= "<td>" . $value["truckManufacturers"] . "</td>";
    $string .= "<td>" . $value["truckModel"] . "</td>";
    $string .= "<td>" . $value["truckName"] . "</td>";
    $string .= "<td><img class='rounded border border-dark' src='./truckPlate.php?string=" . $value['licensePlate'] . "' width='200' height='50'></td>";
    $string .= "<td>" . $value["km"] . "</td>";
    $string .= "<td>" . $value["createDate"] . "</td>";
    if (isset($value["user"])) {
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT firstname FROM USER WHERE idUser = :user");
        $queryPrepared->execute([
            ":user" => $value["user"]
        ]);
        $user = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
        $string .= "<td class='table-success'>" . $user[0]["firstname"] . "</td>";
    } else {
        $string .= "<td class='table-secondary'>Aucun</td>";
    }
    $string .= "<td>";
    if (isset($value["user"])) {
        $string .= "<button class='btn btn-secondary mr-2 mt-1' type='button' title='Ne plus assigner le camion' onclick='
            unassignDriver(" . $value["idTruck"] . ")'><i class='fas fa-user-slash'></i></button>";
        $string .= "<button class='btn btn-dark mr-2 mt-1' type='button' data-toggle='modal' title='Consulter les informations du camion' 
            data-target='#generalInfo' data-whatever='" . $value["idTruck"] . "' onclick='displayTruckId(" . $value["idTruck"] . "); 
            getInfo(" . $value["idTruck"] . "); getOpenDays(" . $value["idTruck"] . "); showMap(" . $value["idTruck"] . ");getTruckMaintenance(" . $value["idTruck"] . ");'><i class='fas fa-info-circle'></i></button>";
    } else {
        $string .= "<button class='btn btn-primary mr-2 mt-1' type='button' data-toggle='modal' title='Assigner le camion à un franchisé'
            data-target='#assignModal' data-whatever='" . $value["idTruck"] . "' onclick='displayTruckId(" . $value["idTruck"] . ")'>
            <i class='fas fa-user-tag'></i></button>";
    }
    $string .= "<button class='btn btn-info mr-2 mt-1' type='button' data-toggle='modal' title='Modifier les informations du camion' 
        data-target='#updateTruck' data-whatever='" . $value["idTruck"] . "' onclick='displayTruckId(" . $value["idTruck"] . "); 
        getInfo(" . $value["idTruck"] . ")'><i class='fas fa-pen'></i></button>";
    $string .= "<button class='btn btn-secondary mr-2 mt-1' type='button' data-toggle='modal' title='Uploader une image du camion' data-target='#truckUpload' onclick='update(" . $value["idTruck"] . ")'><i class='fas fa-file-upload'></i></button>";
    $string .= "</td>";
    $string .= "</tr>";
}
echo $string;