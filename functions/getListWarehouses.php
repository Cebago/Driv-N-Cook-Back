<?php
require '../conf.inc.php';
require '../functions.php';
header("Content-Type: application/json");

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT idWarehouse, warehouseName, warehouseCity, warehouseAddress, warehousePostalCode FROM WAREHOUSES WHERE warehouseType = 'Entrepôt'");
$queryPrepared->execute();
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($result); $i++) {
    $queryPrepared = $pdo->prepare("SELECT COUNT(truck) as count FROM TRUCKWAREHOUSE WHERE warehouse = :warehouse");
    $queryPrepared->execute([
        ":warehouse" => $result[$i]['idWarehouse']
    ]);
    $count = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    $count = $count['count'];
    $result[$i]['truck'] = $count;
}


echo json_encode($result);