<?php
session_start();
require "../conf.inc.php";
require "../functions.php";
header('content-type:application/json');

$idTruck = $_GET["id"];

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT idTruck, truckManufacturers, truckModel, truckName, licensePlate, km FROM pa2a2drivncook.TRUCK WHERE idTruck = :id;");
$queryPrepared->execute([
    ":id" => $idTruck
]);
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($result);
echo $json;