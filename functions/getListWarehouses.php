<?php
require '../conf.inc.php';
require '../functions.php';
header("Content-Type: application/json");

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT idWarehouse, warehouseName, warehouseCity, warehouseAddress, warehousePostalCode FROM WAREHOUSES WHERE warehouseType = 'Entrepôt'");
$queryPrepared->execute();
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($result); $i++) {

    $queryPrepared = $pdo->prepare("SELECT COUNT(truck) as truck FROM TRUCKWAREHOUSE WHERE warehouse = :warehouse");
    $queryPrepared->execute([
        ":warehouse" => $result[$i]['idWarehouse']
    ]);
    $count = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    $count = $count['truck'];
    $result[$i]['truck'] = $count;

    $queryPrepared = $pdo->prepare("SELECT COUNT(ingredient) as ingredient FROM STORE, WAREHOUSES, INGREDIENTS WHERE idIngredient = ingredient AND idWarehouse = warehouse AND available = true AND idWarehouse = :warehouse");
    $queryPrepared->execute([
        ":warehouse" => $result[$i]['idWarehouse']
    ]);
    $ingredient = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    $ingredient = $ingredient['ingredient'];
    $result[$i]['ingredients'] = $ingredient;
}


echo json_encode($result);