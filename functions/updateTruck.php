<?php
session_start();
require "../conf.inc.php";
require "../functions.php";




if (count($_POST) == 6
    && isset($_POST["id"])
    && isset($_POST["manufacturers"])
    && isset($_POST["model"])
    && isset($_POST["license"])
    && isset($_POST["km"])
    && isset($_POST["name"])
) {

    $truck = $_POST["id"];
    $manufacturers = $_POST["manufacturers"];
    $model = $_POST["model"];
    $license = $_POST["license"];
    $km = $_POST["km"];
    $name = $_POST["name"];

    $manufacturers = htmlspecialchars(ucwords(trim($manufacturers)));
    $model = htmlspecialchars(ucwords(trim($model)));
    $license = htmlspecialchars(strtoupper(trim($license)));
    $name = htmlspecialchars(ucwords(trim($name)));

    
    $listOfErrors = "";
    $error = false;
    
    if (!preg_match("#\d*#", $truck)) {
        $error = true;
        $listOfErrors .= "Merci de ne pas modifier l'id du camion \r\n";
    }
    
    if ( (strlen($manufacturers) < 4) && (strlen($manufacturers) > 101) ) {
        $error = true;
        $listOfErrors .= "Veuillez saisir un nom de fabriquant compris entre 5 et 100 caractères \r\n";
    }
    
    if ( (strlen($model) < 4) && (strlen($model) > 101) ) {
        $error = true;
        $listOfErrors .= "Veuillez saisir un modèle de camion compris entre 5 et 100 caractères \r\n";
    }
    if ( (strlen($name) < 4) && (strlen($name) > 101) ) {
        $error = true;
        $listOfErrors .= "Veuillez saisir un nom de camion compris entre 5 et 100 caractères \r\n";
    }
    
    if ( ( !preg_match("#[A-Z]{2}-[0-9]{3}-[A-Z]{2}#", $license) ) && ( !preg_match("#[0-9]{3} [A-Z]{3} [0-9]{2}#", $license) ) ) {
        $error = true;
        $listOfErrors .= "La plaque d'immatriculation n'est pas bonne \r\n";
    }
    if ( ( !preg_match("#\d*#", $km) ) || $km < 0 ) {
        $error = true;
        $listOfErrors .= "Le kilométrage n'est pas bon \r\n";
    }
    
    if ($error) {
        unset($_POST);
        echo $listOfErrors;
    } else {
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare  ("UPDATE TRUCK SET truckManufacturers = :manufacturers,
                                                                            truckModel = :model,
                                                                            licensePlate = :license,
                                                                            km = :km,
                                                                            truckName = :name
                                                    WHERE idTruck = :id"
                                        );
        $queryPrepared->execute([
            ":manufacturers" => $manufacturers,
            ":model" => $model,
            ":license" => $license,
            ":km" => $km,
            ":name" => $name,
            ":id" => $truck
        ]);
    }
} else {
    echo "Merci de ne pas modifier le formulaire !!";
}