<?php
session_start();
require "conf.inc.php";
require "functions.php";

if( count($_POST) == 6
	&& !empty($_POST["firstName"])
	&& !empty($_POST["lastName"]) 
	&& !empty($_POST["inputEmail"]) 
	&& !empty($_POST["inputPassword"])
	&& !empty($_POST["confirmPassword"])
	&& !empty($_POST["captcha"])
) {


	//Nettoyage des chaînes
	$firstName = htmlspecialchars(ucwords(strtolower(trim($_POST["firstName"]))));
	$lastName = htmlspecialchars(strtoupper(trim($_POST["lastName"])));
	$email = strtolower(trim($_POST["inputEmail"]));
	$pwd = $_POST["inputPassword"];
	$pwdConfirm = $_POST["confirmPassword"];
	$captcha = strtolower($_POST["captcha"]);
	

	$error = false;
	$listOfErrors = [];

	


	//firstName : entre 2 caractères et 50
	if( strlen($firstName) < 2 || strlen($firstName) > 50 ) {
		$error = true;
		$listOfErrors[] = "Le prénom doit faire entre 2 et 50 caractères";
	}


	//lastName : entre 2 caractères et 100
	if( strlen($lastName) < 2 || strlen($lastName) > 100 ) {
		$error = true;
		$listOfErrors[] = "Le nom doit faire entre 2 et 100 caractères";
	}

	//captcha
	if($captcha != $_SESSION["captcha"]) {
		$error = true;
		$listOfErrors[] = "Le captcha n'est pas correct";
	}


	//pwd : entre 8 caractères et 30
	//Majuscule, minuscules, chiffres
	if( strlen($pwd) < 8 || strlen($pwd) > 30
		|| !preg_match("#[a-z]#", $pwd)
		|| !preg_match("#[A-Z]#", $pwd)
		|| !preg_match("#\d#", $pwd)
    ){

		$error = true;
		$listOfErrors[] = "Le mot de passe doit faire entre 8 et 30 caractères avec des minuscules, majuscules et chiffres";
	}

	//pwdConfirm : correspond à pwd
	if( $pwdConfirm != $pwd){
		$error = true;
		$listOfErrors[] = "Le mot de passe de confirmation ne correspond pas";
	}


	//email : Correspond à un format d'email
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$error = true;
		$listOfErrors[] = "L'email n'est pas valide";
	}else if(!$error){
		$pdo = connectDB();
		$queryPrepared = $pdo->prepare("SELECT idUser FROM USER WHERE emailAddress=:email");
		$queryPrepared->execute([":email"=>$email]);
		$result = $queryPrepared->fetch();
		if(!empty($result)){
			$error = true;
			$listOfErrors[] = "L'email existe déjà";
		}
	}

	if($error){
		unset($_POST["inputPassword"]);
		unset($_POST["confirmPassword"]);
		$_SESSION["errors"] = $listOfErrors;
		$_SESSION["inputErrors"] = $_POST;
		//Rediriger sur register.php
		header("Location: register.php");

    } else {
    	$pdo = connectDB();
		$query = "INSERT INTO USER (firstname, lastname, emailAddress, pwd, userRole) VALUES
		( :firstname, :lastname, :email, :pwd, :role)";

		$pwd =  password_hash($pwd,PASSWORD_DEFAULT);
        $role = 1;
		

		$queryPrepared = $pdo->prepare($query);
		$queryPrepared->execute( [
									":firstname" => $firstName,
									":lastname" => $lastName,
									":email" => $email,
									":pwd" => $pwd,
                                    ":role" => $role
								] );

		//Génétation d'un token
		$cle= $lastName.$email;
		$cle = md5($cle."drivncookPA2A2ESGIcebago");

		$queryPrepared = $pdo->prepare("SELECT idUser FROM USER WHERE emailAddress = :email");
		$queryPrepared->execute([
								":email"=>$email
								]);
		$result = $queryPrepared->fetch();
		$idUser = $result["idUser"];

		$queryPrepared = $pdo->prepare("UPDATE USER SET token = :token WHERE emailAddress = :email");
		$queryPrepared->execute([
			":token"=>$cle,
			":email"=>$email
		]);
		$destination = $email;
		$subject = "Activation de votre compte Drincook";
		$header = "FROM: client@drivncook.fr";
		$link = "https://drivncook.fr/isActivated?cle=".urlencode($cle);
		$message = '
		Bonjour ' . $lastName . ' ' . $firstName . '
		Bienvenue sur Where 2 Go,
 
		Pour activer votre compte, veuillez cliquer sur le lien ci-dessous ou le copier/coller dans votre navigateur internet.
 		'.$link.'
 		---------------
 		
 		Ceci est un mail automatique,
 		Merci de ne pas y répondre.';

		$message = wordwrap($message, 70, "\r\n");
		mail($destination, $subject, $message, $header);
		header("Location: login.php");
	}
} else {
	die ("Tentative de Hack .... !!!!");
}