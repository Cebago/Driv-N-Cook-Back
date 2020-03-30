<?php
session_start();
include 'header.php';
require 'conf.inc.php';
require 'functions.php'; ?>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="card-deck w-75 mx-auto mt-5">
        <div class="card menu">
            <img src="https://www.humanprogresscenter.com/wp-content/uploads/2016/05/fond-gris.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Gestion de l'entreprise</h5>
            </div>
        </div>
        <div class="card menu">
            <img src="https://www.humanprogresscenter.com/wp-content/uploads/2016/05/fond-gris.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Approvisionnement</h5>
                
            </div>
        </div>
        <div class="card menu">
            <img src="https://www.humanprogresscenter.com/wp-content/uploads/2016/05/fond-gris.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Revenus</h5>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

