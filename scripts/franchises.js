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
            $('#tableUser').DataTable();
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

