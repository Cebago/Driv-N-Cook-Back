<?php
require_once "conf.inc.php";

function connectDB(){
    try{
        $pdo = new PDO(DBDRIVER.":host=".DBHOST.";dbname=".DBNAME ,DBUSER,DBPWD);
        //Permet d'afficher les erreurs SQL
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(Exception $e){
        die("Erreur SQL : ".$e->getMessage());
    }
    return $pdo;
}

function createToken($email){
    $token = md5($email."€monTokenDrivNCook£".time().uniqid());
    $token = substr($token, 0, rand(15, 20));
    return $token;
}

function login($email){
    //Création d'un token
    $token = createToken($email);
    //Insertion en BDD pour l'user qui a pour email $email
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("UPDATE USER SET token = :token WHERE emailAddress = :email ");
    $queryPrepared->execute([":token"=>$token, ":email"=>$email]);
    //Insertion en session du token et de l'email
    $_SESSION["token"] = $token;
    $_SESSION["email"] = $email;
}

function phpSales():string {
    $pdo = connectDB();
    $queryPrepared = $pdo->prepare("SELECT truckmanufacturers, SUM(orderPrice) as sum FROM ORDERS, TRUCK WHERE ORDERS.truck = TRUCK.idTruck
    AND orderDate BETWEEN :dateBegin AND :dateEnd GROUP BY idTruck;");
    $queryPrepared->execute(
        [
            ":dateBegin" => getdate(time())["year"]."-01-01",
            ":dateEnd" => getdate(time())["year"]."-12-31"
        ]
    );
    $result = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    $dataPoints = array();
    foreach ($result as $truck) {
        $dataPoints[] = array("label" => $truck["truckmanufacturers"], "y" => $truck["sum"]);
    }
    return json_encode($dataPoints, JSON_NUMERIC_CHECK);
}