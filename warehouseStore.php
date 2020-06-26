<?php
session_start();
require 'conf.inc.php';
require 'functions.php';
include "header.php";
?>
</head>
<body>
<?php include "navbar.php"; ?>
    <div class="col-md-11 mx-auto">
        <div class="modal-title mt-3">
            <h3>Consulter le stock de chaque entrepôt</h3>
        </div>
        <div>
            <div>
                <div class="input-group mb-3 mt-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="selectWarehouse">Entrepôt : </label>
                    </div>
                    <select class="custom-select" id="selectWarehouse" onchange="warehouseDisplay()">
                        <option selected>Choisir un entrepôt ...</option>
                        <?php
                        $pdo = connectDB();
                        $queryPrepared = $pdo->prepare("SELECT idWarehouse, warehouseName FROM WAREHOUSES WHERE warehouseType = 'Entrepôt' ");
                        $queryPrepared->execute();
                        $warehouses = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($warehouses as $warehouse) {
                            echo "<option value='" . $warehouse["idWarehouse"] . "'>". $warehouse["warehouseName"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div id="warehousePourcentage" class="myDisplay mt-3 mb-3"></div>
                <div id="warehouseList" class="myDisplay mt-3 mb-3"></div>
            </div>
        </div>
    </div>




<script src="scripts/warehouse.js"></script>
<?php include "footer.php"; ?>
</body>
