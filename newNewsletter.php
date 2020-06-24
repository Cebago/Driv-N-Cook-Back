<?php
session_start();
require 'conf.inc.php';
require 'functions.php';

if (isAdmin() && isActivated() && isConnected()) {
    include 'header.php';
    ?>
    </head>
    <body>
    <?php include 'navbar.php'; ?>
    <div class="col-md-5 mx-auto mt-3 mb-3 card pt-3 pb-3 alert-secondary">
        <div>
            <p>test</p>
        </div>
        <div>
            <p>test</p>
        </div>
        <div>
            <p>test</p>
        </div>
        <div>
            <p>test</p>
        </div>
    </div>
    <div class="col-md-5 mx-auto mt-3 mb-3">
        <button class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;Ajouter une zone de texte</button>
        <button class="btn btn-secondary"><i class="far fa-images"></i>&nbsp;Ajouter une image</button>
    </div>
    <?php include 'footer.php'; ?>
    </body>
    <?php
} else {
    header("Location: login.php");
}
?>
