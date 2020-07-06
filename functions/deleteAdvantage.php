<?php
session_start();
require "../conf.inc.php";
require "../functions.php";

if (isset($_GET["id"])) {
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("DELETE FROM ADVANTAGE WHERE idAdvantage = :id");
    $queryPrepared->execute([
        ":id" => $_GET["id"]
    ]);
    header("Location: ../advantages.php");
} else {
    header("Location: ../advantages.php");
}