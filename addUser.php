<?php
session_start();
require "conf.inc.php";
require "functions.php";

if( count($_POST) == 11
	&& !empty($_POST["gender"])
	&& !empty($_POST["firstName"])
	&& !empty($_POST["lastName"]) 
	&& !empty($_POST["inputEmail"]) 
	&& !empty($_POST["inputPassword"])
	&& !empty($_POST["confirmPassword"])
	&& !empty($_POST["inputCity"])
	&& !empty($_POST["postalCode"])
	&& !empty($_POST["inputBirthday"])
	&& !empty($_POST["captcha"])
	&& !empty($_POST["pseudo"])){


	//Nettoyage des chaînes
	$firstName = htmlspecialchars(ucwords(strtolower(trim($_POST["firstName"]))));
	$lastName = htmlspecialchars(strtoupper(trim($_POST["lastName"])));
	$email = strtolower(trim($_POST["inputEmail"]));
	$pwd = $_POST["inputPassword"];
	$pwdConfirm = $_POST["confirmPassword"];
	$captcha = strtolower($_POST["captcha"]);
	$pseudo = htmlspecialchars($_POST["pseudo"]);
	$inputBirthday = $_POST["inputBirthday"];
	$postalCode = $_POST["postalCode"];

	$error = false;
	$listOfErrors = [];

	


	//firstName : entre 2 caractères et 50
	if( strlen($firstName)<2 || strlen($firstName)>50 ){
		$error = true;
		$listOfErrors[] = "Le prénom doit faire entre 2 et 50 caractères";
	}


	//lastName : entre 2 caractères et 100
	if( strlen($lastName)<2 || strlen($lastName)>100 ){
		$error = true;
		$listOfErrors[] = "Le nom doit faire entre 2 et 100 caractères";
	}

	//pseudo
	if( strlen($pseudo)<3 || strlen($pseudo)>15){
		$error = true;
		$listOfErrors[] = "Le pseudo n'est pas valide";
	}else if(!$error){
		$pdo = connectDB();
		$queryPrepared = $pdo->prepare("SELECT idUser FROM XZF_USER WHERE pseudo=:pseudo");
		$queryPrepared->execute([":pseudo"=>$pseudo]);
		$result = $queryPrepared->fetch();
		if(!empty($result)){
			$error = true;
			$listOfErrors[] = "Le pseudo existe déjà";
		}
	}
	

	//captcha
	if($captcha != $_SESSION["captcha"]){
		$error = true;
		$listOfErrors[] = "Le captcha n'est pas correct";
	}


	//pwd : entre 8 caractères et 30
	//Majuscule, minuscules, chiffres
	if( strlen($pwd)<8 || strlen($pwd)>30 
		|| !preg_match("#[a-z]#", $pwd)
		|| !preg_match("#[A-Z]#", $pwd)
		|| !preg_match("#\d#", $pwd) ){

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
		$queryPrepared = $pdo->prepare("SELECT idUser FROM XZF_USER WHERE email=:email");
		$queryPrepared->execute([":email"=>$email]);
		$result = $queryPrepared->fetch();
		if(!empty($result)){
			$error = true;
			$listOfErrors[] = "L'email existe déjà";
		}
	}

	//Code Postal
	if (strlen($postalCode) != 5 
		&& !preg_match("#^[0-9]{5}$#", $postalCode)){
		/* ||!preg_match('^[0-9]{5}$', $postalCode)*/
		$error = true;
		$listOfErrors[] = "Le code postal n'est pas dans un format valide";
	}
	
	//Date de naissance
	if (strlen($inputBirthday) != 10
		&& !preg_match("(([1-2][0-9])|([1-9])|(3[0-1]))/((1[0-2])|([1-9]))/[0-9]{4}",$inputBirthday)){
		$error = true;
		$listOfErrors[] = "La date de naissance n'est pas dans un format valide";
	}
	/*$inputBirthday = date("Y-m-d", $inputBirthday);*/


	if($error){
		unset($_POST["inputPassword"]);
		unset($_POST["confirmPassword"]);
		$_SESSION["errors"] = $listOfErrors;
		$_SESSION["inputErrors"] = $_POST;
		//Rediriger sur register.php
		header("Location: register");

    }else{
    	$pdo = connectDB();
		$query = "INSERT INTO XZF_USER (firstname, lastname, email ,password, pseudo, city, postalCode, gender, created, birthday, friendCode) VALUES
		( :firstname ,:lastname ,:email , :pwd, :pseudo, :city, :postalCode,:gender,:created, :birthday, :friendCode )";

		$pwd =  password_hash($pwd,PASSWORD_DEFAULT);

		$str = "abcdefghijklmnopqrstuvwxyz1234567890";
		$friendCode = substr(str_shuffle($str), rand(0,26), 10);

		$date = getdate();
		$current = $date["year"]."-".$date["mon"]."-".$date["mday"];
		$birthday = date("Y-m-d", strtotime($inputBirthday));

		$queryPrepared = $pdo->prepare($query);
		$queryPrepared->execute( [
									":firstname"=>$firstName,
									":lastname"=>$lastName,
									":email"=>$email,
									":pwd"=>$pwd,
									":pseudo"=>$pseudo,
									":postalCode"=>$postalCode,
									":created"=>$current,
									":birthday"=>$birthday,
									":friendCode"=>$friendCode
								] );

		//Génétation d'un token
		$cle= $pseudo.$email;
		$cle = md5($cle."TB8ISLOD");

		$queryPrepared = $pdo->prepare("SELECT idUser FROM XZF_USER WHERE email = :email");
		$queryPrepared->execute([
								":email"=>$email
								]);
		$result = $queryPrepared->fetch();
		$idUser = $result["idUser"];

		$queryPrepared = $pdo->prepare("UPDATE XZF_USER SET token = :token WHERE email = :email");
		$queryPrepared->execute([
			":token"=>$cle,
			":email"=>$email
		]);

		$queryPrepared = $pdo->prepare("INSERT INTO XZF_LIST (name, description, user ) VALUES ('LIKE', 'Liste de tous les lieux que vous aimez', :user)");
		$queryPrepared->execute([
								":user"=>$idUser
								]);

		$destination = $email;
		$subject = "Activation de votre compte Where2Go";
		$header = "FROM: no-reply-inscription@where2go.fr";
		$link = "https://where2go.fr/isActivated?cle=".urlencode($cle);
		$message = '
		Bonjour '.$pseudo.'
		Bienvenue sur Where 2 Go,
 
		Pour activer votre compte, veuillez cliquer sur le lien ci dessous ou copier/coller dans votre navigateur internet.
 		'.$link.'
 		---------------
 		Ceci est un mail automatique, Merci de ne pas y répondre.';

		mail($destination, $subject, $message, $header);
		
		header("login");
	}
}else{
	die("Tentative de Hack .... !!!!");
}