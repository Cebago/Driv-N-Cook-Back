<?php
session_start();
require 'conf.inc.php';
require 'functions.php';

if (isConnected() && isActivated() && isAdmin()) {
include 'header.php';
?>


<body>
<?php include "navbar.php"; ?>
<div class="menu card mt-2 col-11 mx-auto mt-5">
    <table class="table table-striped mt-2">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Email</th>
            <th scope="col">Numéro</th>
            <th scope="col">Date de création</th>
            <th scope="col">Activation</th>
            <th scope="col">Adresse</th>
            <th scope="col">Code postal</th>
            <th scope="col">Permis n°</th>
            <th scope="col">Role</th>
            <th scope="col">Carte de fidélité</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT idUser, lastname, firstname, emailAddress, phoneNumber, 
                                                    DATE_FORMAT(createDate,'%d/%m/%Y') as createDate,
                                                    isActivated, address, postalCode, licenseNumber, roleName, fidelityCard 
                                                    FROM USER, SITEROLE 
                                                    WHERE idRole = userRole 
                                                    ORDER BY idUser");
        $queryPrepared->execute();
        $users = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $user) {
            echo "<tr>";
            echo "<th scope='row'>" . $user["idUser"] . "</th>";
            echo "<td>" . $user["lastname"] . "</td>";
            echo "<td>" . $user["firstname"] . "</td>";
            echo "<td>" . $user["emailAddress"] . "</td>";
            echo "<td>" . $user["phoneNumber"] . "</td>";
            echo "<td>" . $user["createDate"] . "</td>";
            if ($user["isActivated"]) {
                echo "<td class='table-success'>Activé</td>";
            } else {
                echo "<td class='table-warning'>En attente d'activation</td>";
            }
            echo "<td>" . $user["address"] . "</td>";
            echo "<td>" . $user["postalCode"] . "</td>";
            echo "<td>" . $user["licenseNumber"] . "</td>";
            echo "<td>" . $user["roleName"] . "</td>";
            echo "<td>" . $user["fidelityCard"] . "</td>";
            echo "<td>";
            if ($user["isActivated"]) {
                echo "<a class='btn btn-warning ml-1 mr-1 mt-1 mb-1' href='./functions/desactivateUser.php?id=" . $user["idUser"] . "' title='Désactiver cet uilisateur'><i class='fas fa-user-times'></i></a>";
            } else {
                echo "<a class='btn btn-success ml-1 mr-1 mt-1 mb-1' href='./functions/activateUser.php?id=" . $user["idUser"] . "' title='Activer cet uilisateur'><i class='fas fa-user-plus'></i></a>";
            }
            echo "<a class='btn btn-danger ml-1 mr-1 mt-1 mb-1' href='./functions/deleteUser.php?id=" . $user["idUser"] . "' title='Supprimer cet uilisateur'><i class='fas fa-user-slash'></i></a>";
            echo "<button type='button' data-toggle='modal' data-target='#roleModal' onclick='changeForm(" . $user["idUser"] . ")' class='btn btn-primary ml-1 mr-1 mt-1 mb-1' title='Changer le rôle de cet uilisateur'><i class='fas fa-user-cog'></i></button>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleSelectModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleSelectModal">Changer le rôle de l'utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="userForm">
                <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="selectRole">Rôle</label>
                            </div>
                            <select class="custom-select" name="selectRole" id="selectRole" required>
                                <option selected value="">Choisir un rôle</option>
                                <option value="1">Client</option>
                                <option value="2">Franchisé</option>
                                <option value="3">Administrateur</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="scripts/user.js"></script>
<?php
include "footer.php";
} else {
    header("Location: ");
}
?>
