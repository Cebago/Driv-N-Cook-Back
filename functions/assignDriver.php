<?php
    session_start();
    require "../conf.inc.php";
    require "../functions.php";
    
    if (isset($_POST["user"]) && isset($_POST["truck"])) {
        $user = $_POST["user"];
        $truck = $_POST["truck"];
        
        //userX -> camionX
        
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT idTruck FROM TRUCK, USER WHERE user = idUser AND idUser = :user");
        $queryPrepared->execute([
            ":user" => $user
        ]);
        $result = $queryPrepared->fetch();
        $error = false;
        $listOfErrors = [];
        if(!empty($result)){
            $error = true;
            $listOfErrors[] = "L'utilisateur est déjà assigné à un camion";
        }
        
        $queryPrepared = $pdo->prepare("SELECT user FROM TRUCK WHERE idTruck = :truck");
        $queryPrepared->execute([
            ":truck" => $truck
        ]);
        $result = $queryPrepared->fetch();
        $error = false;
        $listOfErrors = [];
        if(!empty($result)){
            $error = true;
            $listOfErrors[] = "Le camion possède déjà un conducteur";
        }
        
        
        if($error) {
            $_SESSION["errors"] = $listOfErrors;
            $_SESSION["inputErrors"] = $_POST;
            //Rediriger sur register.php
            //header("Location: trucks.php");
            echo "KO";
            echo "<pre>" . print_r($listOfErrors) . "</pre>";
        } else {
            $pdo = connectDB();
            $queryPrepared = $pdo->prepare("UPDATE TRUCK SET user = :user WHERE idTruck = :truck");
            $queryPrepared->execute([
                ":user" => $user,
                ":truck" => $truck
            ]);
            echo "OK"
        }
    }
?>