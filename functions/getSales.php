<?php

session_start();
require "../conf.inc.php";
require "../functions.php";

$sales = [];

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT concat(UPPER(lastname), ' ', firstname) as franchise, idTruck FROM USER, TRUCK WHERE idUser = user");
$queryPrepared->execute();
$users = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $user) {
    $queryPrepared = $pdo->prepare("SELECT orderPrice FROM ORDERS WHERE orderType = 'Commande client' AND truck = :truck AND orderDate BETWEEN :dateBegin AND :dateEnd");
    $queryPrepared->execute([
        ":truck" => $user["idTruck"],
        ":dateBegin" => getdate(time())["year"] . "-01-01",
        ":dateEnd" => getdate(time())["year"] . "-12-31"
    ]);
    $sum = 0;
    $prices = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    foreach ($prices as $price) {
        $sum = $price["orderPrice"] + $sum;
    }
    $sales[] = array("label" => $user["franchise"], "y" => $sum);
}
echo json_encode($sales, JSON_NUMERIC_CHECK);