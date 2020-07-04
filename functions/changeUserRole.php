<?php
session_start();
require "../conf.inc.php";
require "../functions.php";

if (isset($_GET["id"], $_POST["selectRole"])) {
    $id = $_GET["id"];
    $role = $_POST["selectRole"];

    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("UPDATE USER SET userRole = :role WHERE idUser = :user");
    $queryPrepared->execute([
        ":user" => $id,
        ":role" => $role
    ]);
}

header("Location: ../users.php");