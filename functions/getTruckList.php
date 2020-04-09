<?php
    session_start();
    require "../conf.inc.php";
    require "../functions.php";
    
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT * FROM pa2a2drivncook.TRUCK;");
    $queryPrepared->execute();
    $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    $string = "";
    foreach ($result as $value) {
        ////echo "<tr>";
        $string .= "<tr>";
        ////echo "<th scope='row'>" . $value["idTruck"] . "</th>";
        $string .= "<th scope='row'>" . $value["idTruck"] . "</th>";
        //echo "<td>" . $value["truckManufacturers"] . "</td>";
        $string .= "<td>" . $value["truckManufacturers"] . "</td>";
        //echo "<td>" . $value["truckModel"] . "</td>";
        $string .= "<td>" . $value["truckModel"] . "</td>";
        //echo "<td>" . $value["licensePlate"] . "</td>";
        $string .= "<td>" . $value["licensePlate"] . "</td>";
        //echo "<td>" . $value["km"] . "</td>";
        $string .= "<td>" . $value["km"] . "</td>";
        //echo "<td>" . $value["createDate"] . "</td>";
        $string .= "<td>" . $value["createDate"] . "</td>";
        if (isset($value["user"])) {
            $pdo = connectDB();
            $queryPrepared = $pdo->prepare("SELECT firstname FROM USER WHERE idUser = :user");
            $queryPrepared->execute([
                ":user" => $value["user"]
            ]);
            $user = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
            //echo "<td class='table-success'>" . $user[0]["firstname"] . "</td>";
            $string .= "<td class='table-success'>" . $user[0]["firstname"] . "</td>";
        } else {
            //echo "<td class='table-secondary'>Aucun</td>";
            $string .= "<td class='table-secondary'>Aucun</td>";
        }
        //echo "<td>";
        $string .= "<td>";
        if (isset($value["user"])) {
            //echo "<button class='btn btn-secondary mr-2' type='button' onclick='unassignDriver(". $value["idTruck"] . ")'><i class='fas fa-user-slash'></i></button>";
            $string .= "<button class='btn btn-secondary mr-2' type='button' onclick='unassignDriver(". $value["idTruck"] . ")'><i class='fas fa-user-slash'></i></button>";
        } else {
            //echo "<button class='btn btn-primary mr-2' type='button' data-toggle='modal' data-target='#assignModal' data-whatever='" . $value["idTruck"] . "' onclick='displayTruckId(". $value["idTruck"] . ")'><i class='fas fa-user-tag'></i></button>";
            $string .= "<button class='btn btn-primary mr-2' type='button' data-toggle='modal' data-target='#assignModal' data-whatever='" .
                $value["idTruck"] . "' onclick='displayTruckId(". $value["idTruck"] . ")'><i class='fas fa-user-tag'></i></button>";
        }
        //echo "</td>";
        $string .= "</td>";
        //echo "</tr>";
        $string .= "</tr>";
    }
    echo $string;
