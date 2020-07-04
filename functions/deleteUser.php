<?php
session_start();
require "../conf.inc.php";
require "../functions.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("UPDATE USER SET emailAddress = null WHERE idUser = :user");
    $queryPrepared->execute([
        ":user" => $id
    ]);
}
header("Location: ../users.php");