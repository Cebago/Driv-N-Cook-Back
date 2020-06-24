<?php
$file = '../Driv-N-Cook-Client/assets/traduction.json';
$data = file_get_contents($file);
$obj = json_decode($data);
echo "<pre>";
print_r($obj->values);
echo "</pre>";
