<?php
session_start();
require "../conf.inc.php";
require "../functions.php";

$truck = $_POST["truck"];

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT openDay, DATE_FORMAT(startHour,'%H:%i') as startHour, DATE_FORMAT(endHour,'%H:%i') as endHour  FROM OPENDAYS, TRUCK WHERE truck = idTruck AND truck = :truck");
$queryPrepared->execute([
    ":truck" => $truck
]);
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($result);
echo $json;