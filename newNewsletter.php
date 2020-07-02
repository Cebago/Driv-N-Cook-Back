<?php
session_start();
require 'conf.inc.php';
require 'functions.php';

if (isAdmin() && isActivated() && isConnected()) {
include 'header.php';
?>
<body>
<?php include 'navbar.php'; ?>
<div class="col-md-5 mx-auto mt-3 mb-3 card pt-3 pb-3 alert-secondary" id="allTheMail"></div>
<div class="col-md-5 mx-auto mt-3 mb-3">
    <button class="btn btn-primary" onclick="addText()"><i class="fas fa-plus"></i>&nbsp;Ajouter une zone de
        texte
    </button>
    <button class="btn btn-secondary" data-toggle="modal" data-target="#uploadImage"><i class="far fa-images"></i>&nbsp;Ajouter
        une image
    </button>
    <div class="mt-5">
        <p>
            Liste des variables utilisables:
        </p>
        <ul>
            <li>{{LASTNAME}}&nbsp; -> Pour afficher le nom de l'utilisateur</li>
            <li>{{FIRSTNAME}} -> Pour afficher le prénom de l'utilisateur</li>
            <li>{{NB_POINTS}} -> Pour afficher le solde de points de fidélité de l'utilisateur</li>
        </ul>
    </div>
    <button class="btn btn-success" data-toggle="modal" data-target="#saveNewsletter"><i class="fas fa-save"></i>&nbsp;Sauvegarder
    </button>
</div>
<div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-labelledby="uploadImageLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImageLabel">Ajouter une image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mt-1">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#useOne" role="tab"
                               aria-controls="home" aria-selected="true"><i class="fas fa-photo-video"></i>&nbsp;Bibliothèque
                                d'images</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#uploadOne" role="tab"
                               aria-controls="profile" aria-selected="false"><i class="fas fa-upload"></i>&nbsp;Uploader
                                une nouvelle image</a>
                        </li>
                    </ul>
                    <div class="tab-content card mt-1" id="myTabContent">
                        <div class="tab-pane fade show active" id="useOne" role="tabpanel"
                             aria-labelledby="home-tab">
                            <?php
                            $allFiles = glob("newsletterImages/*");
                            for ($i = 0; $i < count($allFiles); $i++) {
                                $imageName = $allFiles[$i];
                                $support = array('gif', 'jpg', 'jpeg', 'png');
                                $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                                if (in_array($ext, $support)) {
                                    echo '<a onclick="addImage(this)" href="#"><img class="ml-2 mr-2 mt-2 mb-2" width="200px" height="200px" src="' . $imageName . '" alt="' . $imageName . '" /></a>';
                                } else {
                                    continue;
                                }
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade" id="uploadOne" role="tabpanel" aria-labelledby="profile-tab">
                            <form method="POST" enctype="multipart/form-data"
                                  onsubmit="return uploadToNewsletter(event)">
                                <div class="input-group mb-3 mt-5 ml-2 mr-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="title">Titre de l'image</span>
                                    </div>
                                    <input type="text" class="form-control mr-4" name="imageTitle" id="imageTitle"
                                           placeholder="Titre de l'image" aria-label="Titre de l'image"
                                           aria-describedby="title" required>
                                </div>
                                <div class="custom-file mb-2 ml-2 mr-2">
                                    <input type="file" class="custom-file-input" id="uploadImage" name="uploadImage"
                                           required>
                                    <label class="custom-file-label mr-4" for="uploadImage">Choisir une
                                        image</label>
                                </div>
                                <button type="submit" class="btn btn-primary mb-3 ml-2 mr-2">Uploader l'image
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="saveNewsletter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sauvegarder la newsletter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="newsletterTitle">Titre de la newsletter</span>
                    </div>
                    <input type="text" class="form-control" id="saveTitle" placeholder="Titre" aria-label="Titre"
                           aria-describedby="newsletterTitle">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveNewsletter()">Valider</button>
            </div>
        </div>
    </div>
</div>

<script src="scripts/newsletter.js"></script>
<?php include 'footer.php'; ?>
<?php
} else {
    header("Location: login.php");
}
?>
