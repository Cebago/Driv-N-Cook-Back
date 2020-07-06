<?php
session_start();
require "../conf.inc.php";
require "../functions.php";

if (isset($_POST["user"]) && isset($_POST["truck"])) {
    $user = $_POST["user"];
    $truck = $_POST["truck"];
    $error = false;
    $listOfErrors = "";

    //userX -> camionX

    if (!preg_match("#\d*#", $user)) {
        $error = true;
        $listOfErrors .= "Vous n'avez pas choisi de conducteur";
        $listOfErrors .= "\n";
    }
    if (!preg_match("#\d*#", $truck)) {
        $error = true;
        $listOfErrors .= "Le camion n'existe pas";
        $listOfErrors .= "\n";
    }

    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT idTruck FROM TRUCK, USER WHERE user = idUser AND idUser = :user");
    $queryPrepared->execute([
        ":user" => $user
    ]);
    $result = $queryPrepared->fetch();
    if (!empty($result)) {
        $error = true;
        $listOfErrors .= "L'utilisateur est déjà assigné à un camion";
        $listOfErrors .= "\n";
    }

    $queryPrepared = $pdo->prepare("SELECT user FROM TRUCK WHERE idTruck = :truck");
    $queryPrepared->execute([
        ":truck" => $truck
    ]);
    $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    if (!empty($result["user"])) {
        $error = true;
        $listOfErrors .= "Le camion possède déjà un conducteur";
        $listOfErrors .= "\n";
    }


    if ($error) {
        $_SESSION["errors"] = $listOfErrors;
        $_SESSION["inputErrors"] = $_POST;
        echo $listOfErrors;
        //Rediriger sur register.php
        //header("Location: ../trucks.php");
    } else {
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("UPDATE TRUCK SET user = :user WHERE idTruck = :truck");
        $queryPrepared->execute([
            ":user" => $user,
            ":truck" => $truck
        ]);
        //header("Location: ../trucks.php");
    }
}
