<?php
session_start();
header("Content-Type: image/png");
$string = $_GET["string"];
$string = htmlspecialchars(strtoupper(trim($string)));
$image = imagecreate(200, 50);
$background = imagecolorallocate($image, 255, 255, 255);
if ( preg_match("#[A-Z]{2}-[0-9]{3}-[A-Z]{2}#", $string)) {
    $lenghtString = strlen($string);
    $captcha = $string;
    $_SESSION["captcha"] = $captcha;

    $listOfFonts = "./fonts/dealerplate california.ttf";
    $startX = 35;

    for ($i = 0; $i < $lenghtString; $i++) {
        $configCaptcha[$i]["size"] = 20;
        $configCaptcha[$i]["font"] = __DIR__ . "/" . $listOfFonts;
        $configCaptcha[$i]["angle"] = 0;
        $configCaptcha[$i]["x"] = (isset($configCaptcha[$i - 1]))
            ? $configCaptcha[$i - 1]["x"] + 15
            : $startX;
        $configCaptcha[$i]["y"] = 35;
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
    $left = imagecreate(20, 50);
    $right = imagecreate(20, 50);

    $colorLeft = imagecolorallocate($left, 0, 0, 255);
    $colorRight = imagecolorallocate($right, 0, 0, 255);

    imagerectangle($left, 0, 0, 40, 100, $colorLeft);
    imagerectangle($right, 0, 0, 40, 100, $colorRight);

    imagecopymerge($image, $left, 0, 0, 0, 0, 25, 50, 100);
    imagecopymerge($image, $right, 175, 0, 0, 0, 25, 50, 100);

    imagepng($image);
} else {
    $lenghtString = strlen($string);
    $captcha = $string;
    $_SESSION["captcha"] = $captcha;
    $listOfFonts = "./fonts/dealerplate california.ttf";
    $startX = 35;
    for ($i = 0; $i < $lenghtString; $i++) {
        $configCaptcha[$i]["size"] = 20;
        $configCaptcha[$i]["font"] = __DIR__ . "/" . $listOfFonts;
        $configCaptcha[$i]["angle"] = 0;
        $configCaptcha[$i]["x"] = (isset($configCaptcha[$i - 1]))
            ? $configCaptcha[$i - 1]["x"] + 13
            : $startX;
        $configCaptcha[$i]["y"] = 35;
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
    $left = imagecreate(20, 50);
    $right = imagecreate(20, 50);

    $colorLeft = imagecolorallocate($left, 0, 0, 255);
    $colorRight = imagecolorallocate($right, 0, 0, 255);

    imagerectangle($left, 0, 0, 40, 100, $colorLeft);
    imagerectangle($right, 0, 0, 40, 100, $colorRight);

    imagecopymerge($image, $left, 0, 0, 0, 0, 25, 50, 100);
    imagecopymerge($image, $right, 175, 0, 0, 0, 25, 50, 100);
}
imagepng($image);