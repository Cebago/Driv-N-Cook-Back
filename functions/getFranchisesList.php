<?php
session_start();
require "../conf.inc.php";
require "../functions.php";
header("Content-Type: application/json");

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT idUser, lastname, firstname, DATE_FORMAT(createDate, '%d/%m/%Y') as createDate FROM USER, TRANSACTION, SITEROLE 
                                            WHERE user = idUser AND userRole = idRole AND roleName = 'Franchisé' 
                                              AND DATE_FORMAT(transactionDate, '%d/%m/%Y') = DATE_FORMAT(createDate, '%d/%m/%Y') GROUP BY idUser");
$queryPrepared->execute();
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($result); $i++) {
    $user = $result[$i]['idUser'];
    $queryPrepared = $pdo->prepare("SELECT SUM(price) AS price FROM TRANSACTION WHERE user = :user");
    $queryPrepared->execute([
        ":user" => $user
    ]);
    $price = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    $result[$i]['price'] = $price['price'];
}



echo json_encode($result);