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
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#franchiseesGest" aria-expanded="true" aria-controls="collapseOne">
                                    Gestion des franchisés
                                </button>
                                <a class="btn btn-link" href="franchisees.php">
                                    Accéder <i class="fas fa-external-link-alt"></i>
                                </a>
                            </h2>
                        </div>
                        <div id="franchiseesGest" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                Accédez à la liste de tous vos franchisés et attribuez leur un camion
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#clientGest" aria-expanded="true" aria-controls="collapseOne">
                                    Gestion des clients
                                </button>
                                <a class="btn btn-link" href="clients.php">
                                    Accéder <i class="fas fa-external-link-alt"></i>
                                </a>
                            </h2>
                        </div>
                        <div id="clientGest" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                Accédez à la liste de tous vos clients
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#truckGest" aria-expanded="true" aria-controls="collapseOne">
                                    Gestion des camions
                                </button>
                                <a class="btn btn-link" href="trucks.php">
                                    Accéder <i class="fas fa-external-link-alt"></i>
                                </a>
                            </h2>
                        </div>
                        <div id="truckGest" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                Accédez à la liste de tous vos camions, gérez leur affectation et consultez leurs incidents
                            </div>
                        </div>
                    </div>
                </div>
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

