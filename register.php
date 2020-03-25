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
                            <form method="POST" action="addUser" enctype="multipart/form-data">
                                <div class="form-label-group">
                                    <div class="form-group ">
                                        <select id="gender" name="gender" class="form-control" required="required">
                                            <option selected>Sexe</option>
                                            <option>Homme</option>
                                            <option>Femme</option>
                                            <option>Autre</option>
                                        </select>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- Prénom -->
                                                <input type="text" id="firstName" class="form-control focus" placeholder="Prénom" required="required" name="firstName"
                                                       value="<?php echo (isset($_SESSION["inputErrors"]))
                                                           ?$_SESSION["inputErrors"]["firstName"]
                                                           :"";?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- Nom -->
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
                                    <input type="email" id="inputEmail" class="form-control focus" placeholder="Email" required="required" name="inputEmail"
                                           value="<?php echo (isset($_SESSION["inputErrors"]))
                                               ?$_SESSION["inputErrors"]["inputEmail"]
                                               :"";?>">
                                </div>
                                <div class="form-group">
                                    <!-- Pseudo -->
                                    <input type="text" id="pseudo" class="form-control focus" placeholder="Pseudonyme" required="required" name="pseudo"
                                           value="<?php echo (isset($_SESSION["inputErrors"]))
                                               ?$_SESSION["inputErrors"]["pseudo"]
                                               :"";?>">
                                </div>
                                <div class="form-group">
                                    <!-- Mot de passe -->
                                    <input type="password" id="inputPassword" class="form-control focus" placeholder="Mot de passe" required="required" name="inputPassword" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <!-- Confirmation mot de passe -->
                                    <input type="password" id="confirmPassword" class="form-control focus" placeholder="Confirmation mot de passe" required="required" name="confirmPassword" autocomplete="off">
                                </div>
                                <div class="form-label-group">
                                    <div class="form-row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- Ville -->
                                                <input type="text" id="inputCity" class="form-control focus" placeholder="Ville" required="required" name="inputCity"
                                                       value="<?php echo (isset($_SESSION["inputErrors"]))
                                                           ?$_SESSION["inputErrors"]["inputCity"]
                                                           :"";?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- Code postal -->
                                                <input type="text" id="pos" class="form-control focus" placeholder="Code postal" required="required"  name="postalCode"
                                                       value="<?php echo (isset($_SESSION["inputErrors"]))
                                                           ?$_SESSION["inputErrors"]["postalCode"]
                                                           :"";?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-label-group">
                                    <div class="form-row">
                                        <div class="col-6">
                                            <div class="form-group text-center vertical-align mt-1">
                                                <!-- Date de naissance -->
                                                <p>Date de naissance : </p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <!-- Date de naissance -->
                                                <input id="inputBirthday" type="date" class="form-control focus" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" name="inputBirthday"
                                                       value="<?php echo (isset($_SESSION["inputErrors"]))
                                                           ?$_SESSION["inputErrors"]["inputBirthday"]
                                                           :"";?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <!-- Captcha image -->
                                        <img src="captcha.php" alt="captcha">
                                    </div>
                                    <!-- Captcha réponse -->
                                    <input type="text" name="captcha" id="inputCaptcha" placeholder="Captcha" required="required" class="form-control focus" autocomplete="off">
                                </div>
                                
                                <input class="btn btn-primary degrade btn-block" type="submit" value="Inscription">
                                
                                
                                
                                <?php
                                $registered = isset($_REQUEST['registered']);
                                if($registered){ ?>
                                    <script>$(document).ready(function(){
                                            $('#test').modal('show');
                                        });</script>
                                <?php } ?>
                                
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