<?php
require '../conf.inc.php';
require '../functions.php';
header("Content-Type: application/json");

$warehouse = $_GET['id'];

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT idWarehouse, warehouseName, warehouseCity, warehouseAddress, warehousePostalCode FROM WAREHOUSES WHERE warehouseType = 'Entrepôt' AND idWarehouse = :warehouse");
$queryPrepared->execute([":warehouse" => $warehouse]);
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
