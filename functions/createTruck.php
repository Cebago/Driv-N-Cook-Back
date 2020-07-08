<?php
session_start();
require "../conf.inc.php";
require "../functions.php";

$warehouse = $_POST["warehouse"];
$manufacturers = $_POST["manufacturers"];
$name = $_POST["name"];
$model = $_POST["model"];
$license = $_POST["license"];
$km = $_POST["km"];

if (count($_POST) == 6) {

    $manufacturers = htmlspecialchars(ucwords(trim($manufacturers)));
    $model = htmlspecialchars(ucwords(trim($model)));
    $license = htmlspecialchars(strtoupper(trim($license)));


    $listOfErrors = "";
    $error = false;

    if (!preg_match("#\d*#", $warehouse)) {
        $error = true;
        $listOfErrors .= "Merci de choisir un entrepôt de rattachement \r\n";
    }

    if ((strlen($manufacturers) < 4) && (strlen($manufacturers) > 101)) {
        $error = true;
        $listOfErrors .= "Veuillez saisir un nom de fabriquant compris entre 5 et 100 caractères \r\n";
    }

    if ((strlen($model) < 4) && (strlen($model) > 101)) {
        $error = true;
        $listOfErrors .= "Veuillez saisir un modèle de camion compris entre 5 et 100 caractères \r\n";
    }

    if ((!preg_match("#[A-Z]{2}-[0-9]{3}-[A-Z]{2}#", $license)) && (!preg_match("#[0-9]{3} [A-Z]{3} [0-9]{2}#", $license))) {
        $error = true;
        $listOfErrors .= "La plaque d'immatriculation n'est pas bonne \r\n";
    } elseif (!$error) {
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT idTruck FROM TRUCK WHERE licensePlate = :license");
        $queryPrepared->execute([
            ":license" => $license
        ]);
        $result = $queryPrepared->fetch();
        if (!empty($result)) {
            $error = true;
            $listOfErrors .= "Un camion avec cette plaque existe déjà";
        }
    }
    if ((!preg_match("#\d*#", $km)) || $km < 0) {
        $error = true;
        $listOfErrors .= "Le kilométrage n'est pas bonne \r\n";
    }

    if ($error) {
        unset($_POST);
        echo $listOfErrors;
    } else {
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("INSERT INTO TRUCK (truckManufacturers, truckModel, licensePlate, km, truckName)
                                                    VALUES (:manufacturers, :model, :license, :km, :name)");
        $queryPrepared->execute([
            ":manufacturers" => $manufacturers,
            ":model" => $model,
            ":license" => $license,
            ":km" => $km,
            ":name" => $name
        ]);
        $idTruck = $pdo->lastInsertId();
        $queryPrepared = $pdo->prepare("INSERT INTO WAREHOUSES (warehouseName, warehouseType)
                                                    VALUES ('Stock du camion', 'Camion')");
        $queryPrepared->execute();
        $idWarehouse = $pdo->lastInsertId();

        $queryPrepared = $pdo->prepare("INSERT INTO TRUCKWAREHOUSE (truck, warehouse)
                                                    VALUES (:truck, :warehouse)");
        $queryPrepared->execute([
            ":truck" => $idTruck,
            ":warehouse" => $warehouse
        ]);
        $queryPrepared = $pdo->prepare("INSERT INTO TRUCKWAREHOUSE (truck, warehouse)
                                                    VALUES (:truck, :warehouse)");
        $queryPrepared->execute([
            ":truck" => $idTruck,
            ":warehouse" => $idWarehouse
        ]);
        echo "truck " . $idTruck;
        echo "entre " . $idWarehouse;
    }
} else {
    echo "Merci de ne pas modifier le formulaire !!";
}