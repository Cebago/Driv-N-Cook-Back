<?php
session_start();
include 'header.php';
require 'conf.inc.php';
require 'functions.php';
?>
</head>
<body>
<?php include 'navbar.php' ?>
<div class="menu mt-5 card col-md-11 mx-auto">
    <h5 class="card-header">Gestion de l'ensemble des franchisés</h5>
    <table class="table table-striped mt-2">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Date d'entrée dans la société</th>
            <th scope="col">Sommme versée</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody id="tablebody"></tbody>
    </table>
</div>
<script>
    function getFranchisesList() {
        const content = document.getElementById("tablebody");

        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if(request.readyState === 4) {
                if(request.status === 200) {
                    //console.log(request.responseText);
                    let myJson = JSON.parse(request.responseText);
                    for (let i = 0; i < myJson.length; i++) {
                        let tr = document.createElement("tr");
                        let th = document.createElement("th");
                        th.setAttribute("scope", "row");
                        th.innerHTML = myJson[i]["idUser"];
                        let td1 = document.createElement("td");
                        td1.innerHTML = myJson[i]["lastname"];
                        let td2 = document.createElement("td");
                        td2.innerHTML = myJson[i]["firstname"];
                        let td3 = document.createElement("td");
                        td3.innerHTML = myJson[i]["createDate"];
                        let td4 = document.createElement("td");
                        td4.innerHTML = myJson[i]["price"] + " €";
                        let td5 = document.createElement("td");
                        tr.appendChild(th);
                        tr.appendChild(td1);
                        tr.appendChild(td2);
                        tr.appendChild(td3);
                        tr.appendChild(td4);
                        tr.appendChild(td5);
                        content.appendChild(tr);
                    }
                }
            }
        };
        request.open('GET', './functions/getFranchisesList.php', true);
        request.send();
    }

    window.onload = getFranchisesList;
    setInterval(refreshTable, 60000);

</script>

<?php include 'footer.php' ?>
</body>
