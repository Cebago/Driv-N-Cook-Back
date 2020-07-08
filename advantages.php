<?php
session_start();
require 'conf.inc.php';
require 'functions.php';

if (!isAdmin() || !isConnected()) {
    header("Location: login.php");
}

include 'header.php';
?>
<body>
<div class="col-md-11 mx-auto mt-5">
    <button class="btn btn-primary" data-toggle="modal" data-target="#advantageModal">Ajouter un avantage</button>
</div>
<div class="col-md-11 mx-auto mt-5 card">
    <table class="table table-striped" id="advantagesTab">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Nom de l'avantage</th>
            <th>Nombre de points</th>
            <th>Catégorie associée</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $pdo = connectDB();
        $queryPrepared = $pdo->prepare("SELECT idAdvantage, advantageName, advantagePoints, categoryName FROM ADVANTAGE, PRODUCTCATEGORY WHERE idCategory = category");
        $queryPrepared->execute();
        $advantages = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

        $queryPrepared = $pdo->prepare("SELECT idCategory, categoryName FROM PRODUCTCATEGORY");
        $queryPrepared->execute();
        $categories = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);


        foreach ($advantages as $advantage) { ?>
            <tr>
                <th><?php echo $advantage["idAdvantage"] ?></th>
                <td><?php echo $advantage["advantageName"] ?></td>
                <td><?php echo $advantage["advantagePoints"] ?></td>
                <td><?php echo $advantage["categoryName"] ?></td>
                <td><a href="./functions/deleteAdvantage.php?id=<?php echo $advantage["idAdvantage"] ?>"
                       class="btn btn-warning">Supprimer cet avantage</a></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="advantageModal" tabindex="-1" role="dialog" aria-labelledby="advantageModalLabel"
     aria-hidden="true">
    <form method="POST" action="./functions/addAdvantage.php">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="advantageModalLabel">Ajouter un avantage</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="advantageName">Nom</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nom de l'avantage" name="advantageName"
                               aria-label="advantagePoints" aria-describedby="advantageName" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="advantagePoints">Nombre de points</span>
                        </div>
                        <input type="number" min="0" class="form-control" placeholder="Nombre de points"
                               name="advantagePoints" aria-label="advantagePoints" aria-describedby="advantagePoints"
                               required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="advantageCategory">Options</label>
                        </div>
                        <select class="custom-select" id="advantageCategory" name="advantageCategory" required>
                            <option selected value="">Choisir...</option>
                            <?php
                            foreach ($categories as $category) {
                                echo "<option value='" . $category["idCategory"] . "'>" . $category["categoryName"] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
include 'footer.php';
?>

<script>
    $(document).ready(function () {
        $('#advantagesTab').DataTable();
    });

</script>