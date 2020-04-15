<?php

    session_start();
    require "../conf.inc.php";
    require "../functions.php";

    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT truckmanufacturers, SUM(orderPrice) as sum FROM ORDERS, TRUCK WHERE ORDERS.truck = TRUCK.idTruck
    AND orderDate BETWEEN :dateBegin AND :dateEnd GROUP BY idTruck;");
    $queryPrepared->execute(
        [
            ":dateBegin" => getdate(time())["year"]."-01-01",
            ":dateEnd" => getdate(time())["year"]."-12-31"
        ]
    );
    $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    $dataPoints = array();
    foreach ($result as $truck) {
        $dataPoints[] = array("label" => $truck["truckmanufacturers"], "y" => $truck["sum"]);
    }
    $dataPoints = json_encode($dataPoints, JSON_NUMERIC_CHECK);
    echo $dataPoints;