<?php
session_start();
header("Content-Type: image/png");
$lenghtCaptcha = rand(6,8);
$charAuthorized = "abcdefghijklmnopqrstuvwxyz1234567890";
$charAuthorized = str_shuffle($charAuthorized);
$captcha = substr($charAuthorized, -$lenghtCaptcha);
$_SESSION["captcha"] = $captcha;
$image = imagecreate(300,100);
$listOfFonts = glob("fonts/*.ttf");
$startX = rand(10,20);
$background = imagecolorallocate($image, rand(0,100), rand(0,100), rand(0,100));
for ($i=0; $i<$lenghtCaptcha; $i++) {
    $configCaptcha[$i]["size"] = rand(25,35);
	$configCaptcha[$i]["font"] = __DIR__."/".$listOfFonts[array_rand($listOfFonts)];
	$configCaptcha[$i]["angle"] = rand(-20,20);
	$configCaptcha[$i]["x"] = (isset($configCaptcha[$i-1]))
								?$configCaptcha[$i-1]["x"]+rand(30,40)
								:$startX;
	$configCaptcha[$i]["y"] = rand(40,80);
	$configCaptcha[$i]["color"] = imagecolorallocate($image, rand(150,255), rand(150,255), rand(150,255));
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
$geometryNb = rand(5,10);
for($j=0;$j<$geometryNb;$j++){
	$geometry = rand(0,3);
	switch ($geometry) {
		case 0:
			imageline($image, rand(0,300), rand(0,100), rand(0,300), rand(0,100), $configCaptcha[rand(0,$i-1)]["color"]);
			break;
		case 1:
			imageellipse($image, rand(0,300), rand(0,100), rand(0,300), rand(0,100), $configCaptcha[rand(0,$i-1)]["color"]);
			break;

		case 2:
			imagerectangle($image, rand(0,300), rand(0,100), rand(0,300), rand(0,100), $configCaptcha[rand(0,$i-1)]["color"]);
			break;

		case 3:
			imagepolygon($image, [rand(0,300),rand(0,300),rand(0,300),rand(0,300),rand(0,300),rand(0,300)], 3, $configCaptcha[rand(0,$i-1)]["color"]);
			break;
		default:
			die("Erreur de programmation");
			break;
	}
}
imagepng($image);