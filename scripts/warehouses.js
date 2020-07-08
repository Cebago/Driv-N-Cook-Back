function getListWarehouses() {
    const content = document.getElementById("tablebody");

    while (content.firstChild) {
        content.removeChild(content.firstChild);
    }

    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                let myJson = JSON.parse(request.responseText);
                for (let i = 0; i < myJson.length; i++) {
                    const tr = document.createElement('tr');
                    const th = document.createElement('th');
                    th.scope = "row";
                    th.innerHTML = myJson[i]["idWarehouse"];
                    tr.appendChild(th);
                    const newJson = Object.keys(myJson[i]);
                    for (let j = 1; j < newJson.length; j++) {
                        this['td' + j] = document.createElement('td');
                        this['td' + j].innerHTML = myJson[i][newJson[j]];
                        tr.appendChild(this['td' + j]);
                    }
                    const td = document.createElement('td');
                    const updateButton = document.createElement('button');
                    updateButton.setAttribute('data-toggle', 'modal');
                    updateButton.setAttribute('data-target', '#updateWarehouse');
                    updateButton.setAttribute('data-whatever', myJson[i]["idWarehouse"]);
                    updateButton.className = "btn btn-info mr- mt-1";
                    updateButton.innerHTML = "<i class='fas fa-edit'></i>";
                    updateButton.type = "button";
                    updateButton.title = "Modifier les informations de l'entrepôt";
                    updateButton.setAttribute('onclick', "getInfo(" + myJson[i]['idWarehouse'] + ")");
                    td.appendChild(updateButton);
                    if (Number(myJson[i]["truck"]) === 0 && Number(myJson[i]["ingredients"]) === 0) {
                        const deleteButton = document.createElement('button');
                        deleteButton.className = "btn btn-info ml-1 mr-1 mt-1";
                        deleteButton.innerHTML = '<i class="fas fa-times"></i>';
                        deleteButton.type = "button";
                        deleteButton.title = "Supprimer l'entrepôt";
                        deleteButton.setAttribute('onclick', "deleteWarehouse(" + myJson[i]['idWarehouse'] + ")");
                        td.appendChild(deleteButton);
                    }
                    tr.appendChild(td);
                    content.appendChild(tr);

                }

                $(document).ready(function () {
                    $('#tabWarehouses').DataTable();
                });
            }
        }
    };
    request.open('GET', './functions/getListWarehouses.php', true);
    request.send();
}

function createWarehouse() {
    let name = document.getElementById('warehouseName');
    let city = document.getElementById('warehouseCity');
    let address = document.getElementById('warehouseAddress');
    let postalCode = document.getElementById('postalCode');
    name = name.value;
    city = city.value;
    address = address.value;
    postalCode = postalCode.value;
    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                if (request.responseText !== "") {
                    alert(request.responseText);
                }
            }
        }
    };
    request.open('POST', './functions/createWarehouse.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("name=" + name
        + "&city=" + city
        + "&address=" + address
        + "&postalCode=" + postalCode
    );
    setTimeout(getListWarehouses, 1000);
}

function updateWarehouse() {
    const warehouse = document.getElementById("idWarehouse").value;
    const name = document.getElementById("nameWarehouse").value;
    const city = document.getElementById("cityWarehouse").value;
    const address = document.getElementById("addressWarehouse").value;
    const postalCode = document.getElementById("warehouseZip").value;
    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                if (request.responseText !== "") {
                    alert(request.responseText);
                }
            }
        }
    };
    request.open('POST', './functions/updateWarehouse.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(
        "id=" + warehouse
        + "&name=" + name
        + "&city=" + city
        + "&address=" + address
        + "&postalCode=" + postalCode
    );
    setTimeout(getListWarehouses, 1000);
}

function deleteWarehouse(id) {
    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                if (request.responseText !== "") {
                    console.log(request.responseText);
                }
            }
        }
    };
    request.open('POST', './functions/deleteWarehouse.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(
        "id=" + id
    );
    setTimeout(getListWarehouses, 1000);
}

function getInfo(idWarehouse) {
    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                let myJson = JSON.parse(request.responseText);
                const warehouse = document.getElementsByClassName("updateWarehouse");
                for (let i = 0; i < warehouse.length; i++) {
                    const input = document.getElementsByName(warehouse[i].name);
                    input[0].value = myJson[0][warehouse[i].name];
                }
            }
        }
    };
    request.open('GET', './functions/getWarehouseInfo.php?id=' + idWarehouse, true);
    request.send();
}


window.onload = getListWarehouses;
setInterval(getListWarehouses, 60000);