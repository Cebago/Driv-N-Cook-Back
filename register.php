<?php
session_start();
include "header.php";
include "functions.php";
?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <section class="register pt-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-11 col-md-9 col-lg-7 mx-auto">
                    <div class="card card-login mx-auto mt-5 p-5">
                        <?php
                        if ( ($_SERVER["SERVER_NAME"] == "back.drivncook.fr")
                            || ($_SERVER["SERVER_NAME"] == "franchises.drivncook.fr")
                        ){
                        ?>
                            <div class="card-body alert alert-warning">
                                Pour vous connecter en tant que client, allez sur le lien suivant <a href="https://drivncook.fr/login.php">Connexion</a>
                            </div>
                        <?php
                        } else if ( ($_SERVER["SERVER_NAME"] == "www.back.drivncook.com")
                                    || ($_SERVER["SERVER_NAME"] == "www.franchises.drivncook.com")
                        ) {
                        ?>
                            <div class="card-body alert alert-warning">
                                Pour vous connecter en tant que client, allez sur le lien suivant <a href="https://www.drivncook.com/login.php">Connexion</a>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="text-center">
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-5">
                                    <a class="text-secondary" href="login">Se connecter</a>
                                </div>
                                <div class="col-5">
                                    <p class="underline" href="register">S'inscrire</p>
                                </div>
                                <div class="col-1"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            if( isset($_SESSION["errors"])){
                                echo "<div class='alert alert-danger'>";
                                foreach ($_SESSION["errors"] as $error) {
                                    echo "<li>".$error;
                                }
                                echo "</div>";
                            }
                            unset($_SESSION["errors"]);
                            ?>
                            <form method="POST" action="addUser.php" enctype="multipart/form-data">
                                <div class="form-label-group">
                                    <div class="form-row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- Prénom -->
                                                <label for="firstName">
                                                    Prénom :
                                                </label>
                                                <input type="text" id="firstName" class="form-control focus" placeholder="Prénom" required="required" name="firstName"
                                                       value="<?php echo (isset($_SESSION["inputErrors"]))
                                                           ?$_SESSION["inputErrors"]["firstName"]
                                                           :"";?>" >
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- Nom -->
                                                <label for="lastName">
                                                    Nom :
                                                </label>
                                                <input type="text" id="lastName" class="form-control focus" placeholder="Nom" required="required" name="lastName"
                                                                                     value="<?php echo (isset($_SESSION["inputErrors"]))
                                                           ?$_SESSION["inputErrors"]["lastName"]
                                                           :"";?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- Email -->
                                    <label for="inputEmail">
                                        Adresse email :
                                    </label>
                                    <input type="email" id="inputEmail" class="form-control focus" placeholder="Email" required="required" name="inputEmail"
                                                                           value="<?php echo (isset($_SESSION["inputErrors"]))
                                               ?$_SESSION["inputErrors"]["inputEmail"]
                                               :"";?>">
                                </div>
                                <div class="form-group">
                                    <!-- Mot de passe -->
                                    <label for="inputPassword">
                                        Mot de passe :
                                    </label>
                                    <input type="password" id="inputPassword" class="form-control focus" placeholder="Mot de passe" required="required" name="inputPassword" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <!-- Confirmation mot de passe -->
                                    <label for="confirmPassword">
                                        Confirmation de mot de passe :
                                    </label>
                                    <input type="password" id="confirmPassword" class="form-control focus" placeholder="Confirmation mot de passe" required="required" name="confirmPassword" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <!-- Captcha image -->
                                        <img src="captcha.php" alt="captcha">
                                    </div>
                                    <!-- Captcha réponse -->
                                    <label for="inputCaptcha">
                                        Captcha :
                                    </label>
                                    <input type="text" name="captcha" id="inputCaptcha" placeholder="Captcha" required="required" class="form-control focus" autocomplete="off">
                                </div>
                                <input class="btn btn-primary degrade btn-block" type="submit" value="Inscription">
                                <div class="registerConfirm">
                                    <div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header pt-4 mx-auto">
                                                    <h5 class="modal-title">Merci de votre inscription !</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center mx-2">
                                                    Cliquez sur le lien dans l'email que nous vous avons envoyé pour confirmer votre compte et pouvoir vous connecter.
                                                    <img class="pt-3 w-25" src="pictures/email.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-3"></div>
    
    </section>
<?php include 'footer.php' ?>