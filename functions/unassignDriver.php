<?php
    session_start();
    require "../conf.inc.php";
    require "../functions.php";
    
    if (isset($_POST["truck"])) {
        $truck = $_POST["truck"];
        $error = false;
        $listOfErrors = [];
    
        if (!preg_match("#\d*#", $truck)) {
            $error = true;
            $listOfErrors[] = "Le camion n'existe pas";
        }
        
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("UPDATE TRUCK SET user = null WHERE idTruck = :truck");
        $queryPrepared->execute([
            ":truck" => $truck
        ]);
        $queryPrepared = $pdo->prepare("INSERT INTO TRUCKSTATUS (truck, status, updateDate) VALUES (:truck, :status, CURRENT_TIMESTAMP) 
                                                            ON DUPLICATE KEY UPDATE updateDate = CURRENT_TIMESTAMP");
        $queryPrepared->execute([
            ":truck" => $truck,
            ":status" => 11
        ]);
    }