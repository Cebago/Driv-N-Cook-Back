<?php
require 'conf.inc.php';
require 'functions.php';


function getTrucksStats(){
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT truckName, lastname, firstname,
		(SELECT SUM(price) FROM TRANSACTION WHERE transactionType = 'buyWarehouse' AND user = idUser ) as buyWarehouse,
		(SELECT SUM(price) FROM TRANSACTION WHERE transactionType = 'buyExtern' AND user = idUser) as buyExtern,
		(SELECT SUM(price) FROM TRANSACTION WHERE transactionType = 'client' AND user = idUser) as client
FROM USER, TRUCK WHERE TRUCK.user = idUser ;");
    $queryPrepared->execute();
    return $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
}






