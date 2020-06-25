<?php
require "../conf.inc.php";
require "../functions.php";


$code = $_POST['html'];
$code = rawurldecode($code);
echo $code;