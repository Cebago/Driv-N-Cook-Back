<?php
require "../conf.inc.php";
require "../functions.php";

if (count($_POST) == 1 && isset($_POST["id"])) {
    $warehouse = $_POST['id'];
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT ingredient FROM STORE WHERE warehouse = :warehouse");
    $queryPrepared->execute([
        ":warehouse" => $warehouse
    ]);
    $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result)) {
        $queryPrepared = $pdo->prepare("DELETE FROM STORE WHERE warehouse = :warehouse");
        $queryPrepared->execute([
            ":warehouse" => $warehouse
        ]);
    }
    $queryPrepared = $pdo->prepare("DELETE FROM WAREHOUSES WHERE idWarehouse = :warehouse");
    $queryPrepared->execute([
        ":warehouse" => $warehouse
    ]);
}