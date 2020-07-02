<?php

session_start();
require 'conf.inc.php';
require 'functions.php';
include 'header.php';
?>
</head>
<body>
<?php include "navbar.php";
?>

<div class="row justify-content-center" style="margin-top: 20px;">
    <div class="col-md-10">
        <table class="table table-striped table-bordered table-hover table-hover-cursor" style="table-layout: fixed" id="tblData">
            <thead class="thead-light">
                <tr class="d-flex">
                    <th class="col-2">Expediteur</th>
                    <th class="col-3">Sujet</th>
                    <th class="col-5">Contenu</th>
                    <th class="col-1">Date</th>
                    <th class="col-1">Lecture</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $messages = getMessages($_SESSION["email"]);
                foreach ($messages as $message){
            ?>

            <tr <?php echo $message["isRead"]?'':'style="font-weight: bold"'?> class="d-flex">
                <td class="text-truncate col-2">v</</td>
                <td class="text-truncate col-3"><?php echo $message["contactSubject"]?></td>
                <td class="text-truncate col-5"><?php echo $message["contactDescription"]?></td>
                <td class="text-truncate col-1"><?php echo $message["createDate"]?></td>
                <td class="col-1"><button type="button" class="btn btn-success btn-sm" data-toggle="modal"  data-target="#modal<?php echo $message["idContact"]?>"><i class="fab fa-readme"></i></button></td>
            </tr>

            <?php }?>
            </tbody>
        </table>
    </div>
</div>

<?php foreach ($messages as $message){?>

    <!-- Modal -->
    <div class="modal fade" id="modal<?php echo $message["idContact"]?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel"><?php echo $message["firstname"].' '.$message["lastname"]?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="staticBackdropLabel"> <?php echo $message["contactSubject"]?></h5><br>

                    <?php echo $message["contactDescription"]?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="location.href='mailto:<?php echo $message["emailAddress"]?>' "   >Répondre</button>
                </div>
            </div>
        </div>
    </div>
<?php }?>

<?php include "footer.php"; ?>



