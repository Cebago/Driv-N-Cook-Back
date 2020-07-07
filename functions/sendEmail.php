<?php
require '../conf.inc.php';
require '../functions.php';

$subject = $_POST["subject"];

$emails = [];

if (isset($_POST['allEmails'])) {
    $all = explode(";", preg_replace("/\s+/", "", $_POST["allEmails"]));
    $emails = filter_var_array($all, FILTER_VALIDATE_EMAIL);
} elseif (isset($_POST["myEmail"])) {
    $emails[] = $_POST['myEmail'];
} else {
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT emailAddress FROM USER, SITEROLE WHERE userRole = idRole AND roleName='Client' AND fidelityCard <> ''");
    $queryPrepared->execute();
    $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $value) {
        $emails[] = $value["emailAddress"];
    }
    $emails = filter_var_array($emails, FILTER_VALIDATE_EMAIL);
}

foreach ($emails as $email) {
    $destination = $email;

    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT firstname, lastname, points, acceptEmails FROM USER, FIDELITY WHERE emailAddress = :email AND fidelityCard = idFidelity");
    $queryPrepared->execute([
        ":email" => $email
    ]);
    $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    if ($result["acceptEmails"] == 0) {
        continue;
    }
    $firstName = $result["firstname"];
    $lastName = $result["lastname"];
    $points = $result["points"];

    $admin = ($_SERVER["SERVER_ADMIN"]);
    $domaineAddresse = substr($admin, strpos($admin, '@') + 1, strlen($admin));
    $header = "From: no-reply@" . $domaineAddresse . "\n";
    $header .= "X-Sender: <no-reply@" . $domaineAddresse . "\n";
    $header .= "X-Mailer: PHP\n";
    $header .= "Return-Path: <no-reply@" . $domaineAddresse . "\n";
    $header .= "Content-Type: text/html; charset=iso-8859-1\n";
    $html = file_get_contents("../" . $_POST["selectNewsletter"]);
    $html = str_replace("{{FIRSTNAME}}", $firstName . " !", $html);
    $html = str_replace("{{LASTNAME}}", $lastName, $html);
    $html = str_replace("{{NB_POINTS}}", $points, $html);
    mail($destination, $subject, $html, $header);
}

header("Location: ../allNewsletter.php");
