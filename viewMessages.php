<?php

session_start();
require 'conf.inc.php';
require 'functions.php';
include 'header.php';
?>
</head>
<body>
<?php include "navbar.php"; ?>

<div class="container">
    <table class="table table-striped table-bordered table-hover table-hover-cursor" style="table-layout: fixed" id="tblData">
        <thead class="thead-light">
        <tr>
            <th scope="col" data-bind="tableSort: { arr: _data, propName: 'text()'}">Text</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-truncate">wedwewe ewfwefwe</td>
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



