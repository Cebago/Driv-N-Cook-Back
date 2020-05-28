<?php
session_start();
require "../conf.inc.php";
require "../functions.php";
header("Content-type: application/json");

$id = $_POST["idTruck"];
$truck = [];
$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT idMaintenance, maintenanceName as Nom, DATE_FORMAT(maintenanceDate, '%d/%m/%Y') as Date, maintenancePrice as Prix, km as Kilométrage FROM MAINTENANCE WHERE truck = :truck ORDER BY DATE(maintenanceDate) DESC;");
$queryPrepared->execute([
    ":truck" => $id
]);
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
$truck["truck"] = $result;
$queryPrepared = $pdo->prepare("SELECT idStatus, statusName, DATE_FORMAT(updateDate, '%d/%m/%Y') as updateDate, DATE_FORMAT(updateDate, '%H:%i') as updateHour FROM STATUS, TRUCKSTATUS WHERE STATUS.idStatus = TRUCKSTATUS.status AND truck = :truck");
$queryPrepared->execute([
    ":truck" => $id
]);
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
$truck["status"] = $result;
echo json_encode($truck);
