<?php
session_start();
require "../conf.inc.php";
require "../functions.php";
header("Content-Type: application/json");

$user = $_POST["user"];

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT price, DATE_FORMAT(transactionDate, '%d/%m/%Y %H:%i') as transactionDate FROM TRANSACTION WHERE user = :user");
$queryPrepared->execute([
    ":user" => $user
]);
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($result);
echo $json;