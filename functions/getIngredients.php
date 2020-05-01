<?php
session_start();
require "../conf.inc.php";
require "../functions.php";
header("Content-type: application/json");

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT * FROM INGREDIENTS");
$queryPrepared->execute();
$ingredient = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
$i = 0;
foreach ($ingredient as $item) {
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT warehouseName, available FROM STORE, INGREDIENTS, WAREHOUSES WHERE ingredient = idIngredient AND ingredient = :ingredient
                                                AND warehouse = idWarehouse AND warehouseType = 'Entrepôt'");
    $queryPrepared->execute([":ingredient" => $item["idIngredient"]]);
    $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    $tmp = [];
    if (empty($result)) {
        $ingredient[$i]['warehouses'] = null;
    } else {
        foreach ($result as $key => $store) {
            $tmp[$store["warehouseName"]] = $store["available"];
        }
        $ingredient[$i] = array_merge($ingredient[$i], array('warehouses' => $tmp));
    }
    $i++;
}
$json = json_encode($ingredient);
echo $json;