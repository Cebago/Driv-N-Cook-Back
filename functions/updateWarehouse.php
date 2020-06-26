<?php
require '../conf.inc.php';
require '../functions.php';
header("Content-Type: application/json");

if ((count($_POST) == 5)
    && isset($_POST['name'])
    && isset($_POST['city'])
    && isset($_POST['address'])
    && isset($_POST['postalCode'])
    && isset($_POST['id'])
) {

    $listOfErrors = "";
    $error = false;

    $id = $_POST["id"];
    $name = htmlspecialchars(ucwords(trim($_POST['name'])));
    $city = htmlspecialchars(ucwords(trim($_POST['city'])));
    $address = htmlspecialchars(ucwords(trim($_POST['address'])));
    $postalCode = $_POST['postalCode'];

    if (!((strlen($name) > 5) && (strlen($name) < 100))) {
        $error = true;
        $listOfErrors .= "Veuillez saisir un nom d'entrepôt compris entre 5 et 100 caractères \r\n";
    }

    if (!((strlen($city) > 3) && (strlen($city) < 100))) {
        $error = true;
        $listOfErrors .= "Veuillez saisir un nom de ville compris entre 3 et 100 caractères \r\n";
    }

    if (!((strlen($address) > 10) && (strlen($address) < 100))) {
        $error = true;
        $listOfErrors .= "Veuillez saisir une adresse comprise entre 10 et 100 caractères \r\n";
    }

    if (!preg_match("#^[0-9]{5}$#", $postalCode) && strlen($postalCode) != 5) {
        $error = true;
        $listOfErrors .= "Le code postal n'est pas valide";
    }

    if ($error) {
        unset($_POST);
        echo $listOfErrors;
    } else {
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("UPDATE WAREHOUSES SET 
                      warehouseName = :name, 
                      warehouseCity = :city, 
                      warehouseAddress = :address, 
                      warehousePostalCode = :postalCode 
            WHERE idWarehouse = :warehouse");
        $queryPrepared->execute([
            ":name" => $name,
            ":city" => $city,
            ":address" => $address,
            ":postalCode" => $postalCode,
            ":warehouse" => $id
        ]);
    }
} else {
    echo "Formulaire incomplet";
}