<?php
require '../conf.inc.php';
require '../functions.php';

if ((count($_POST) == 4)
    && isset($_POST['name'])
    && isset($_POST['city'])
    && isset($_POST['address'])
    && isset($_POST['postalCode'])) {

    $listOfErrors = "";
    $error = false;


}