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
}