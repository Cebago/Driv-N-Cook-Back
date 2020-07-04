<?php
session_start();
require '../conf.inc.php';
require '../functions.php';

if (count($_POST) == 12
    && !empty($_POST["idUser"])
    && !empty($_POST["lastname"])
    && !empty($_POST["firstname"])
    && !empty($_POST["emailAddress"])
    && !empty($_POST["phoneNumber"])
    && !empty($_POST["roleName"])
    && !empty($_POST["createDate"])
    && !empty($_POST["address"])
    && !empty($_POST["postalCode"])
    && !empty($_POST["city"])
    && !empty($_POST["licenseNumber"])
    && !empty($_POST["fidelityCard"])) {

    $listOfErrors = [];
    $error = false;
    $user = $_POST['idUser'];
    $firstName = htmlspecialchars(ucwords(strtolower(trim($_POST["firstname"]))));
    $lastName = htmlspecialchars(strtoupper(trim($_POST["lastname"])));
    $email = strtolower(trim($_POST["emailAddress"]));
    $phone = $_POST["phoneNumber"];
    $address = htmlspecialchars(ucwords(trim($_POST["address"])));
    $zip = $_POST["postalCode"];
    $city = htmlspecialchars(ucwords(trim($_POST["city"])));
    $license = $_POST["licenseNumber"];


} else {
    die ("Tentative de Hack .... !!!!");
}
