<?php
require "../conf.inc.php";
require "../functions.php";

$previous = '<!DOCTYPE html>
<html>
    <head>
        <meta lang="FR">
        <meta charset="UTF-8">
        <title>Mail Sender</title>
        <link rel="icon" href="./img/banner.png">
    </head>
    <body style="
        font-family: \'Helvetica Neue\', \'Arial\', \'Noto Sans\', \'sans-serif\', \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\';
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
        width: 860px;
        margin: auto auto 0 auto;

        }">';

$next = '<p>Un geste simple pour l\'environnement, n\'imprimez ce message que si vous en avez l\'utilité.<p><br><p style="text-align: justify;">Conformément à la loi n°78-17 du 6 janvier 1978 modifiée et au règlement (UE) n°2016/679 du 27 avril 2016 vous pouvez exercer votre droit d\'accès, de rectification, d’opposition et d’effacement pour motifs légitimes. Vous disposez, également, d’un droit à la limitation du traitement et à la portabilité des données à caractère personnel vous concernant. Ces droits peuvent être exercés par courrier à l’adresse suivante : Tour Driv\'n cook – 6ème étage – Direction Clients & Territoires - Service National Consommateurs – 242, Avenue du Faubourg Saint-Antoine, 75015 Paris. Votre courrier doit préciser votre nom et prénom, votre adresse actuelle et votre mail, accompagnée d’une pièce justificative d’identité. Vous avez le droit d’introduire une réclamation auprès de la CNIL. </p></body></html>';

$code = $_POST['html'];
$content = $previous . $code . $next;

$title = $_POST['title'];
$code = rawurldecode($code);
$file = "../newsletters/" . $title . ".html";

if (!file_exists($file)) {
    file_put_contents($file, $content);
} else {
    echo "Ce fichier existe déjà";
}

