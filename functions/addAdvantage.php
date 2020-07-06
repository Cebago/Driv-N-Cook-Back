<?php
session_start();
require "../conf.inc.php";
require "../functions.php";

if (isset($_POST["advantageName"], $_POST["advantagePoints"], $_POST["advantageCategory"])) {

    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("INSERT INTO ADVANTAGE (advantageName, advantagePoints, category) VALUES (:name, :points, :id)");
    $queryPrepared->execute([
        ":name" => $_POST["advantageName"],
        ":points" => $_POST["advantagePoints"],
        ":id" => $_POST["advantageCategory"]
    ]);
    header("Location: ../advantages.php");
} else {
    header("Location: ../advantages.php");
}