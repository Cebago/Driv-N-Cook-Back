<?php

session_start();
require 'conf.inc.php';
require 'functions.php';
include 'header.php';
?>
</head>
<body>
<?php include "navbar.php";
var_dump($_SESSION);
?>

<div class="container">
    <table class="table table-striped table-bordered table-hover table-hover-cursor" style="table-layout: fixed" id="tblData">
        <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Expediteur</th>
            <th>Sujet</th>
            <th>Contenu</th>
            <th>Date</th>

        </tr>
        </thead>
        <tbody>
        <?php
            $messages = getMessages($_SESSION["email"]);
            var_dump($messages);

        ?>

        <tr>
            <td class="text-truncate">ID Message</td>
            <td class="text-truncate"> ewfwefwe</td>
            <td class="text-truncate">wedwewe ewfwefwe</td>
            <td class="text-truncate">wedwewe ewfwefwe</td>
        </tr>
        <tr>
            <td class="text-truncate">wedwewe ewfwefwe</td>
            <td class="text-truncate">wedwewe ewfwefwe</td>
            <td class="text-truncate">wedwewe ewfwefwe 2r3r erg thtrt hrdidefzefozpfzfejfozjfopzfjoezfjopezjfozjfozejooefjepofjpefjeofjeofjeofjeofjeofjeofjeofjoefjoeojfoeht </td>
            <td class="text-truncate">wedwewe ewfwefwe</td>
        </tr>
        </tbody>
    </table>
</div>
<?php include "footer.php"; ?>



