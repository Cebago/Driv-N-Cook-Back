<?php
session_start();
require "../conf.inc.php";
require "../functions.php";

if (isset($_POST["money"]) && isset($_POST['user'])) {
    $deposit = $_POST["money"];
    $user = $_POST['user'];
    $error = false;
    $listOfErrors = "";

    if ($deposit <= 0 && !preg_match("#\d*#", $deposit)) {
        $error = true;
        $listOfErrors = "Le montant saisi n'est pas un nombre valide";
    }
    if ($error) {
        echo $listOfErrors;
    } else {
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("INSERT INTO TRANSACTION (transactionDate, transactionType, price, user) VALUES (CURRENT_TIMESTAMP, 'accompte', :money, :user)");
        $queryPrepared->execute([
            ":money" => $deposit,
            ":user" => $user
        ]);
    }
}