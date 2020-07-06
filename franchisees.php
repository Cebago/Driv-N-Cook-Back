<?php
session_start();
require 'conf.inc.php';
require 'functions.php';

if (isConnected() && isActivated() && isAdmin()) {
include 'header.php';
?>
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
            <th scope="col">Somme versée</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody id="tablebody"></tbody>
    </table>
</div>

<div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="priceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Consulter le solde d'un franchisé</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="identity">Franchisé</span>
                    </div>
                    <input type="text" id="assign" class="form-control Franchise" name="idTruck" placeholder="idTruck"
                           aria-label="truckId" aria-describedby="addon-wrapping" readonly>
                </div>
                <div id="franchisee"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="priceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assigner un conducteur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="identity">Franchisé</span>
                    </div>
                    <input type="text" id="franchiseeName" class="form-control Franchise" name="franchiseeName"
                           placeholder="franchiseeName" aria-label="franchiseeName" aria-describedby="addon-wrapping"
                           readonly>
                </div>
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="sum">Somme</span>
                    </div>
                    <input type="number" id="price" class="form-control" name="price" placeholder="Somme versée"
                           aria-label="price" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="priceAdd" data-dismiss="modal">Valider le versement</button>
            </div>
        </div>
    </div>
</div>

<script>
    function getFranchisesList() {
        const content = document.getElementById("tablebody");
        while (content.firstChild) {
            content.removeChild(content.firstChild);
        }

        const request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState === 4) {
                if (request.status === 200) {
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
                        let priceButton = document.createElement("button");
                        priceButton.className = "btn btn-primary ml-3 mr-3 mt-3 mb-3";
                        priceButton.innerHTML = "Consulter le solde";
                        priceButton.setAttribute("title", "Consulter le solde");
                        priceButton.setAttribute("type", "button");
                        priceButton.setAttribute("data-target", "#priceModal");
                        priceButton.setAttribute("data-toggle", "modal");
                        priceButton.setAttribute("onclick", "displayFranchisee('" + myJson[i]["lastname"] + "', '"
                            + myJson[i]["firstname"] + "'); consultDeposit(" + myJson[i]["idUser"] + ")");
                        td5.appendChild(priceButton);
                        let addDepositButton = document.createElement("button");
                        addDepositButton.className = "btn btn-secondary ml-3 mr-3 mt-3 mb-3";
                        addDepositButton.innerHTML = "Ajouter un versement";
                        addDepositButton.setAttribute("title", "Ajouter un versement");
                        addDepositButton.setAttribute("type", "button");
                        addDepositButton.setAttribute("data-target", "#addModal");
                        addDepositButton.setAttribute("data-toggle", "modal");
                        addDepositButton.setAttribute("onclick", "displayFranchisee('" + myJson[i]["lastname"] + "', '"
                            + myJson[i]["firstname"] + "'); updateButton(" + myJson[i]["idUser"] + ")");
                        td5.appendChild(addDepositButton);
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

    function consultDeposit(user) {
        const calendar = document.getElementById("franchisee");
        while (calendar.firstChild) {
            calendar.removeChild(calendar.firstChild);
        }

        const request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState === 4) {
                if (request.status === 200) {
                    //console.log(request.responseText);
                    let myJson = JSON.parse(request.responseText);
                    for (let i = 0; i < myJson.length; i++) {
                        let pdiv = document.createElement("div");
                        pdiv.className = "input-group flex-nowrap";
                        let mdiv = document.createElement("div");
                        mdiv.className = "input-group-prepend mt-1";
                        let span = document.createElement("span");
                        span.className = "input-group-text";
                        span.innerHTML = myJson[i]["transactionDate"];
                        mdiv.appendChild(span);
                        let input = document.createElement("input");
                        input.type = "text";
                        input.className = "form-control mt-1";
                        input.placeholder = "Prix payé";
                        input.value = myJson[i]["price"] + " €";
                        input.setAttribute("readonly", "readonly");
                        pdiv.appendChild(mdiv);
                        pdiv.appendChild(input);
                        calendar.appendChild(pdiv);
                    }
                }
            }
        };
        request.open('POST', './functions/consultDeposit.php', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send("user=" + user);
    }

    function addDeposit(user) {
        let input = document.getElementById('price');
        money = Number(input.value);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState === 4) {
                if (request.status === 200) {
                    if (request.responseText !== "") {
                        alert(request.responseText);
                    } else {
                        input.value = "";
                    }
                }
            }
        };
        request.open('POST', './functions/addDeposit.php', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send("money=" + money + "&user=" + user);
        setTimeout(getFranchisesList, 3000);
    }

    function displayFranchisee(lastname, firstname) {
        const franchisee = document.getElementsByClassName("Franchise");
        for (let i = 0; i < franchisee.length; i++) {
            franchisee[i].value = lastname.toUpperCase() + " " + firstname;
        }
    }

    function updateButton(id) {
        const button = document.getElementById("priceAdd");
        console.log(id);
        button.setAttribute("onclick", "addDeposit(" + id + ")")
    }

    window.onload = getFranchisesList;
    setInterval(getFranchisesList, 60000);

</script>

<?php
include 'footer.php';
} else {
    header("Location: login.php");
}
?>
