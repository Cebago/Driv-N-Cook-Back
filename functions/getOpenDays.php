<?php
session_start();
require "../conf.inc.php";
require "../functions.php";

$truck = $_POST["truck"];

$pdo = connectDB();
$queryPrepared = $pdo->prepare("SELECT openDay FROM pa2a2drivncook.OPENDAYS WHERE truck = :truck GROUP BY openDay ORDER BY DAYOFWEEK(openDay)");
$queryPrepared->execute([
    ":truck" => $truck
]);
$day = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
$tmp = [];
for ($i = 0; $i < count($day); $i++) {
    $queryPrepared = $pdo->prepare("SELECT openDay, DATE_FORMAT(startHour,'%H:%i') as startHour, DATE_FORMAT(endHour,'%H:%i') as endHour FROM OPENDAYS WHERE truck = :truck AND openDay = :day ORDER BY hour(startHour)");
    $queryPrepared->execute([
        ":day" => $day[$i]["openDay"],
        ":truck" => $truck
    ]);
    $open = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    $tmp = array_merge($tmp, $open);
}

echo json_encode($tmp);