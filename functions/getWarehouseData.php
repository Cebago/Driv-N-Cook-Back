<?php
require '../conf.inc.php';
require '../functions.php';
header("Content-Type: application/json");

$warehouse = $_GET['id'];

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT ingredientCategory as label,  COUNT(*) / 
                                     (SELECT COUNT(*) FROM STORE, WAREHOUSES, INGREDIENTS WHERE idWarehouse = warehouse AND idWarehouse = :warehouse AND idIngredient = ingredient GROUP BY idWarehouse) * 100 as y
                                            FROM STORE, WAREHOUSES, INGREDIENTS 
                                            WHERE idWarehouse = warehouse AND idWarehouse = :warehouse AND idIngredient = ingredient 
                                            GROUP BY ingredientCategory");
$queryPrepared->execute([":warehouse" => $warehouse]);
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
for ($i = 0; $i < count($result); $i++) {
    $type = $result[$i]['label'];
    $queryPrepared = $pdo->prepare("SELECT ingredientName FROM INGREDIENTS, STORE WHERE ingredientCategory = :type AND idIngredient = ingredient AND warehouse = :id");
    $queryPrepared->execute([
        ":type" => $type,
        ":id" => $warehouse
    ]);
    $list = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    $result[$i]["ingredientList"] = $list;
}
echo json_encode($result);