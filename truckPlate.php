<?php
session_start();
header("Content-Type: image/png");
$string = $_GET["string"];
$lenghtCaptcha = strlen($string);
$captcha = $string;
$_SESSION["captcha"] = $captcha;
$image = imagecreate(400,100);
$listOfFonts = "./fonts/dealerplate california.ttf";
$startX = 60;
$background = imagecolorallocate($image, 255, 255, 255);
for ($i=0; $i<$lenghtCaptcha; $i++) {
    $configCaptcha[$i]["size"] = 35;
    $configCaptcha[$i]["font"] = __DIR__."/".$listOfFonts;
    $configCaptcha[$i]["angle"] = 0;
    $configCaptcha[$i]["x"] = (isset($configCaptcha[$i-1]))
        ?$configCaptcha[$i-1]["x"] + 30
        :$startX;
    $configCaptcha[$i]["y"] = 60;
    $configCaptcha[$i]["color"] = imagecolorallocate($image, 0, 0, 0);
    imagettftext(
        $image,
        $configCaptcha[$i]["size"],
        $configCaptcha[$i]["angle"],
        $configCaptcha[$i]["x"],
        $configCaptcha[$i]["y"],
        $configCaptcha[$i]["color"],
        $configCaptcha[$i]["font"],
        $captcha[$i]
    );
}
$left = imagecreate(40, 100);
$colorLeft = imagecolorallocate($left, 0, 0, 255);
$right = imagecreate(40, 100);
$colorRight = imagecolorallocate($right, 0, 0, 255);
imagerectangle($left, 0, 0, 40, 100, $colorLeft);
imagerectangle($right, 0, 0, 40, 100, $colorRight);
imagecopymerge($image, $left, 0, 0, 0, 0, 40, 100, 100 );
imagecopymerge($image, $right, 360, 0, 0, 0, 40, 100, 100 );
imagepng($image);