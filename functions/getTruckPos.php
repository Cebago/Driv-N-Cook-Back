<?php
session_start();
require "../conf.inc.php";
require "../functions.php";
header('content-type:application/json');

$pdo = connectDB();
if(isset($_GET["id"])) {
    $idTruck = $_GET["id"];
    $queryPrepared = $pdo->prepare("SELECT lng, lat FROM LOCATION WHERE truck = :id;");
    $queryPrepared->execute([
        ":id" => $idTruck
    ]);
}else{
    $queryPrepared = $pdo->prepare("SELECT lng, lat, truck, truckName, truckManufacturers, truckModel, licensePlate, km,  DATE_FORMAT(createDate,'%d/%m/%Y') as createDate FROM LOCATION, TRUCK WHERE idTruck = truck");
    $queryPrepared->execute();
}

$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($result);
$json = json_encode($result);
echo $json;

