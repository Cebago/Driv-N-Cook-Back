<?php
session_start();
require "../conf.inc.php";
require "../functions.php";
header("Content-Type: application/json");

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT idUser, lastname, firstname, DATE_FORMAT(createDate, '%d/%m/%Y') as createDate, price FROM USER, TRANSACTION, SITEROLE 
                                            WHERE user = idUser AND userRole = idRole AND roleName = 'Franchisé' 
                                              AND transactionDate = createDate");
$queryPrepared->execute();
$result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);