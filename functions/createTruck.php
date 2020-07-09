<?php
session_start();
require "../conf.inc.php";
require "../functions.php";



if (count($_POST) == 7) {

    $warehouse = $_POST["warehouse"];
    $manufacturers = $_POST["manufacturers"];
    $name = $_POST["name"];
    $model = $_POST["model"];
    $license = $_POST["license"];
    $km = $_POST["km"];
    $category = $_POST["category"];

    $manufacturers = htmlspecialchars(ucwords(trim($manufacturers)));
    $model = htmlspecialchars(ucwords(trim($model)));
    $license = htmlspecialchars(strtoupper(trim($license)));
    $category = htmlspecialchars(strtoupper(trim($category)));


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

    if ((strlen($category) < 4) && (strlen($category) > 101)) {
        $error = true;
        $listOfErrors .= "Veuillez saisir une catégorie de camion compris entre 5 et 100 caractères \r\n";
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
        $queryPrepared = $pdo->prepare("INSERT INTO TRUCK (truckManufacturers, truckModel, licensePlate, km, truckName, categorie)
                                                    VALUES (:manufacturers, :model, :license, :km, :name, :category)");
        $queryPrepared->execute([
            ":manufacturers" => $manufacturers,
            ":model" => $model,
            ":license" => $license,
            ":km" => $km,
            ":name" => $name,
            ":category" => $category
        ]);

        $idTruck = $pdo->lastInsertId();

        $queryPrepared = $pdo->prepare("INSERT INTO LOCATION (truck) VALUES (:id)");
        $queryPrepared->execute([
            ":id" => $idTruck
        ]);

        $queryPrepared = $pdo->prepare("INSERT INTO WAREHOUSES (warehouseName, warehouseType)
                                                    VALUES ('Stock du camion', 'Camion')");
        $queryPrepared->execute();
        $idWarehouse = $pdo->lastInsertId();

        $queryPrepared = $pdo->prepare("INSERT INTO TRUCKWAREHOUSE (truck, warehouse)
                                                    VALUES (:truck, :warehouse)");
        $queryPrepared->execute([
            ":truck" => $idTruck,
            ":warehouse" => $idWarehouse
        ]);
        $queryPrepared = $pdo->prepare("INSERT INTO TRUCKWAREHOUSE (truck, warehouse)
                                                    VALUES (:truck, :warehouse)");
        $queryPrepared->execute([
            ":truck" => $idTruck,
            ":warehouse" => $idWarehouse
        ]);
    }
} else {
    echo "Merci de ne pas modifier le formulaire !!";
}