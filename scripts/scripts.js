function showMap(idTruck) {

    let opt = {
        center: new google.maps.LatLng(48.8376962, 2.3896693),
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map;
    if (idTruck)
        map = new google.maps.Map(document.getElementById("map1Truck"), opt);
    else
        map = new google.maps.Map(document.getElementById("mapAllTrucks"), opt);

    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                if (request.responseText !== "") {
                    let myJson = JSON.parse(request.responseText);
                    console.log(myJson);
                    for (var i = 0; i < myJson.length; i++) {
                        let marker = new google.maps.Marker({
                            position: new google.maps.LatLng(myJson[i]["lng"], myJson[i]["lat"]),
                            icon: 'img/truck.png',
                            map: map
                        });
                        if (idTruck) {
                            let geocoder = new google.maps.Geocoder;
                            let latlng = {lat: parseFloat(myJson[0]["lat"]), lng: parseFloat(myJson[0]["lng"])};
                            geocoder.geocode({'location': latlng}, function (results, status) {
                                if (status === 'OK') {
                                    if (results[0]) {

                                        var marker = new google.maps.Marker({
                                            position: latlng,
                                            map: map
                                        });
                                        var smallInfoString = '<div id="content" class="dataInfos">' +
                                            '<div id="siteNotice">' +
                                            '</div>' +
                                            '<h6>' + myJson[0]["truckName"] + '</h6>' +
                                            '<div>' + results[0].formatted_address + '</div>' +
                                            '<div id="bodyContent">' +
                                            '</div>';
                                        let smallInfo = new google.maps.InfoWindow({
                                            content: smallInfoString
                                        });
                                        smallInfo.open(map, marker);
                                    } else {
                                        window.alert('No results found');
                                    }
                                } else {
                                    window.alert('Geocoder failed due to: ' + status);
                                }
                            });


                        } else {
                            let smallInfoString = '<div id="content" class="dataInfos">' +
                                '<div id="siteNotice">' +
                                '</div>' +
                                '<h6>' + myJson[i]["truckName"] + '</h6>' +
                                '<div id="bodyContent">' +
                                '<div> Cliquer pour plus d\'informations </div>' +
                                '</div>';

                            let smallInfo = new google.maps.InfoWindow({
                                content: smallInfoString
                            });
                            let firstname = myJson[i]["firstname"] || "Personne";
                            let largeInfoString = '<div id="content" class="dataInfos">' +
                                '<div id="siteNotice">' +
                                '</div>' +
                                '<h5>' + myJson[i]["truckName"] + '</h5>' +
                                '<div id="bodyContent">' +
                                '<div><b><i class="fas fa-truck"></i>&nbsp' + myJson[i]["truckManufacturers"] + ' ' + myJson[i]["truckModel"] + ' </b></div>' +
                                '<div><i class="fas fa-road"></i>&nbsp' + myJson[i]["km"] + ' Kiliomètres parcourus</div>' +
                                '<div><i class="fas fa-table"></i>&nbsp Créé le ' + myJson[i]["createDate"] + '</div>' +
                                '<div><i class="fas fa-user-circle"></i>&nbsp Conduit par ' + firstname + '</div>' +
                                '<div><i class="fas fa-id-badge"></i>&nbsp Immatriculation: ' + myJson[i]["licensePlate"] + '</div>' +
                                '<div><br>Double cliquer pour accéder à la page du camion</div>' +
                                '</div>';
                            let link = "https://drivncook.fr/truckMenu.php?idTruck=" + myJson[i]["idTruck"];

                            let largeInfo = new google.maps.InfoWindow({
                                content: largeInfoString
                            });

                            marker.addListener('mouseover', function () {
                                smallInfo.open(map, marker);
                            });
                            marker.addListener('click', function () {
                                smallInfo.close(map, marker);
                                largeInfo.open(map, marker);
                            });
                            marker.addListener('mouseout', function () {
                                smallInfo.close(map, marker);
                                largeInfo.close(map, marker);
                            });
                            marker.addListener('dblclick', function () {
                                window.open(
                                    link,
                                    '_blank'
                                );
                            });
                        }
                    }
                }
            }
        }
        return 0;
    };
    if (idTruck) {
        request.open('GET', 'functions/getTruckPos.php?id=' + idTruck);
        console.log("avec user" + idTruck)
    } else
        request.open('GET', 'functions/getTruckPos.php');
    request.send();

};

function refreshTable() {
    const content = document.getElementById("tablebody");

    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                //console.log(request.responseText);
                content.innerHTML = request.responseText;
            }
        }
    };
    request.open('GET', './functions/getTruckList.php', true);
    request.send();
}

function displayTruckId(idTruck) {
    const truckID = document.getElementsByClassName("truckID");
    for (let i = 0; i < truckID.length; i++) {
        truckID[i].value = idTruck;
    }
}

function unassignDriver(idtruck) {
    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                //console.log(request.responseText);
            }
        }
    };
    request.open('POST', 'functions/unassignDriver.php');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(
        'truck=' + idtruck
    );
    setTimeout(refreshTable, 1000);
}

function assignTruck() {
    const truck = document.getElementById("assign").value;
    const user = document.getElementById("select").value;

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
    request.open('POST', 'functions/assignDriver.php');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(
        'user=' + user +
        "&truck=" + truck
    );
    setTimeout(refreshTable, 1000);
}

function getInfo(idtruck) {
    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                let truckJson = JSON.parse(request.responseText);
                const truck = document.getElementsByClassName("truck");
                for (let i = 0; i < truck.length; i++) {
                    const input = document.getElementsByName(truck[i].name);
                    ;
                    input[0].value = truckJson[0][truck[i].name];
                }
            }
        }
    };
    request.open('GET', './functions/getTruckInfo.php?id=' + idtruck, true);
    request.send();
}

function createTruck() {
    const manufacturers = document.getElementById("truckManufacturers").value;
    const model = document.getElementById("truckModel").value;
    const license = document.getElementById("licensePlate").value;
    const truckName = document.getElementById("truckName").value;
    const km = document.getElementById("truckKm").value;
    const warehouse = document.getElementById("truckWarehouse").value;
    const category = document.getElementById("truckCategory").value;

    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                console.log(request.responseText);
            }
        }
    };
    request.open('POST', 'functions/createTruck.php');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(
        'manufacturers=' + manufacturers +
        "&name=" + truckName +
        '&model=' + model +
        '&license=' + license +
        '&km=' + km +
        '&warehouse=' + warehouse +
        '&category=' + category
    );
    setTimeout(refreshTable, 1000);
}

function getOpenDays(idtruck) {
    const table = document.getElementById("tableBody");
    table.innerText = "";

    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                let myJson = JSON.parse(request.responseText);
                const tbody = document.getElementById("tableBody");
                for (let i = 0; i < myJson.length; i++) {
                    const tr = document.createElement("tr");
                    const search = document.getElementById(myJson[i]["openDay"]);
                    if (search === null) {
                        const thd = document.createElement("th");
                        thd.scope = "row";
                        thd.id = myJson[i]["openDay"];
                        thd.innerText = myJson[i]["openDay"];
                        tr.appendChild(thd);
                    } else {

                        search.setAttribute("rowspan", "2");
                        search.className = "align-middle";
                    }
                    const td1 = document.createElement("td");
                    td1.innerText = myJson[i]["startHour"];
                    td1.className = "text-center";
                    const td2 = document.createElement("td");
                    td2.innerText = myJson[i]["endHour"];
                    td2.className = "text-center";
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tbody.appendChild(tr);
                }
            }
        }
    };
    request.open('POST', 'functions/getOpenDays.php');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(
        'truck=' + idtruck
    );
    setTimeout(refreshTable, 1000);
}

function updateTruck() {
    const id = document.getElementById("update")
    const manufacturers = document.getElementById("updateManufacturers");
    const model = document.getElementById("updateModel");
    const license = document.getElementById("updateLicense");
    const km = document.getElementById("updateKM");
    const truckName = document.getElementById("updateName");

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
    request.open('POST', './functions/updateTruck.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(
        'id=' + id.value +
        '&manufacturers=' + manufacturers.value +
        '&model=' + model.value +
        '&name=' + truckName.value +
        '&license=' + license.value +
        '&km=' + km.value
    );
    setTimeout(refreshTable, 1000);
}

function maintenancePage(number, max) {
    const next = document.getElementById("next");
    const previous = document.getElementById("previous");
    const active = document.getElementsByClassName("page-item active");
    for (let i = 0; i < active.length; i++) {
        active[i].className = "page-item";
    }
    const page = document.getElementsByName("link" + number);
    page[0].parentElement.className = "page-item active"
    let ref = page[0].href;
    let search = "";
    for (let i = ref.search("#") + 1; i < ref.length; i++) {
        search += ref[i];
    }
    let elementName = search.slice(0, -1);
    const allElements = document.getElementsByName(elementName);
    for (let i = 0; i < allElements.length; i++) {
        allElements[i].className = "tab-pane fade";
    }

    const collapse = document.getElementById(search);
    collapse.className = "tab-pane fade show active";
    if (number === 1) {
        previous.className = "page-item disabled";
    } else {
        previous.className = "page-item";
        let child = previous.firstChild;
        child.setAttribute("onclick", "maintenancePage(" + (number - 1) + ", " + max + ")");
    }
    if (number === max) {
        next.className = "page-item disabled";
    } else {
        next.className = "page-item";
        let child = next.firstChild;
        child.setAttribute("onclick", "maintenancePage(" + (number + 1) + ", " + max + ")")
    }
}

function getTruckMaintenance(truck) {
    const status = document.getElementById("truckStatus");
    while (status.firstChild) {
        status.removeChild(status.firstChild)
    }

    const maintenance = document.getElementById("maintenanceContent");
    while (maintenance.firstChild) {
        maintenance.removeChild(maintenance.firstChild)
    }

    const pagination = document.getElementById("pagination");
    while (pagination.firstChild) {
        pagination.removeChild(pagination.firstChild)
    }
    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                let truckJson = JSON.parse(request.responseText);
                //console.log(truckJson);
                const statusKeys = Object.keys(truckJson["status"]);
                const truckStatus = truckJson["status"][statusKeys[0]]["idStatus"];
                const p = document.createElement("p");
                if (Number(truckStatus) === 14) {
                    p.className = "text-sucess mb-5";
                    p.innerHTML = "<i class='fas fa-check'></i>&nbsp;Camion disponible";
                } else {
                    p.className = "text-danger mb-5";
                    p.innerHTML = "<i class='fas fa-times'></i>&nbsp;Camion indisponible";
                }
                status.appendChild(p);
                let number = truckJson["truck"].length;
                let max = Math.ceil(truckJson["truck"].length / 5);

                for (let i = 1; i < max + 1; i++) {
                    const div = document.createElement("div");
                    div.id = "tabShow" + i;
                    div.setAttribute("name", "tabShow");
                    if (i === 1) {
                        div.className = "tab-pane fade show active";
                    } else {
                        div.className = "tab-pane fade";
                    }
                    div.setAttribute("role", "tabpanel");
                    div.setAttribute("aria-labelledby", "tab" + i);

                    this["div" + i] = document.createElement("div");
                    this["div" + i].className = "accordion";
                    this["div" + i].id = "truckAccordion" + i;
                    for (let j = 5 * (i - 1); j <= 5 * i - 1 && j < number; j++) {
                        let index = Object.keys(truckJson["truck"]);
                        let field = Object.keys(truckJson["truck"][index[j]]);
                        const card = document.createElement("div");
                        card.className = "card";
                        const header = document.createElement("div");
                        header.className = "card-header";
                        header.id = "header" + Number(j + 1);
                        const h2 = document.createElement("h2");
                        h2.className = "mb-0";
                        const button = document.createElement("button");
                        button.className = "btn btn-link btn-block text-left";
                        button.type = "button";
                        button.setAttribute("data-toggle", "collapse")
                        button.setAttribute("data-target", "#collapse" + Number(j + 1));
                        button.setAttribute("aria-expanded", "false")
                        button.setAttribute("aria-controls", "collapse" + Number(j + 1));
                        button.innerText = truckJson["truck"][index[j]]["Nom"];
                        h2.appendChild(button);
                        header.appendChild(h2);
                        card.appendChild(header);

                        const collapse = document.createElement("div");
                        collapse.id = "collapse" + Number(j + 1);
                        collapse.className = "collapse";
                        collapse.setAttribute("aria-labelledby", "header" + Number(j + 1));
                        collapse.setAttribute("data-parent", "#truckAccordion" + i);
                        const body = document.createElement("div");
                        body.className = "card-body";
                        for (let x = 1; x < field.length; x++) {
                            const desc = document.createElement("p");
                            desc.innerText = field[x] + " : " + truckJson["truck"][index[j]][field[x]];
                            body.appendChild(desc);
                        }
                        collapse.appendChild(body);
                        card.appendChild(collapse);

                        this["div" + i].appendChild(card);
                        div.appendChild(this["div" + i]);
                        maintenance.appendChild(div)
                        //console.log("i = " + i + " j = " + Number(j + 1));
                    }
                }
                if (max === 0 || max < 0) {
                    const text = document.createElement("p");
                    text.innerText = "Aucune maintenance pour ce camion";
                    pagination.appendChild(text);
                } else {
                    const nav = document.createElement('nav');
                    nav.setAttribute("aria-label", "Page navigation example");
                    const ul = document.createElement("ul");
                    ul.className = "pagination justify-content-center";
                    const previousArrow = document.createElement("li");
                    previousArrow.className = "page-item disabled";
                    previousArrow.id = "previous";
                    const previousLink = document.createElement("a");
                    previousLink.href = "#";
                    previousLink.className = "page-link";
                    previousLink.setAttribute("aria-label", "Previous");
                    const preSpan = document.createElement("span");
                    preSpan.setAttribute("aria-hidden", "true");
                    preSpan.innerHTML = "&laquo;";
                    previousLink.appendChild(preSpan);
                    previousArrow.appendChild(previousLink);
                    ul.appendChild(previousArrow);
                    for (let i = 1; i < max + 1; i++) {
                        this["li" + i] = document.createElement("li");
                        if (i === 1) {
                            this["li" + i].className = "page-item active";
                        } else {
                            this["li" + i].className = "page-item";
                        }
                        this["button" + i] = document.createElement("a");
                        this["button" + i].className = "page-link nav-tabs";
                        this["button" + i].id = "tab" + i;
                        this["button" + i].setAttribute("role", "tab");
                        this["button" + i].setAttribute("toggle", "tab");
                        this["button" + i].setAttribute("aria-controls", "tabShow" + i);
                        if (i === 1) {
                            this["button" + i].setAttribute("aria-selected", "true");
                        } else {
                            this["button" + i].setAttribute("aria-controls", "false");
                        }
                        this["button" + i].href = "#tabShow" + i;
                        this["button" + i].name = "link" + i;
                        this["button" + i].setAttribute("onclick", "maintenancePage(" + i + ", " + max + ")");
                        this["button" + i].innerText = i;
                        this["li" + i].appendChild(this["button" + i]);
                        ul.appendChild(this["li" + i]);
                    }
                    nav.appendChild(ul);
                    const nextArrow = document.createElement("li");
                    nextArrow.className = "page-item";
                    nextArrow.id = "next";
                    const nextLink = document.createElement("a");
                    nextLink.href = "#";
                    nextLink.className = "page-link";
                    nextLink.setAttribute("aria-label", "Previous");
                    nextLink.setAttribute("onclick", "maintenancePage(" + 2 + ", " + max + ")");
                    const nextSpan = document.createElement("span");
                    nextSpan.setAttribute("aria-hidden", "true");
                    nextSpan.innerHTML = "&raquo;";
                    nextLink.appendChild(nextSpan);
                    nextArrow.appendChild(nextLink);
                    ul.appendChild(nextArrow);
                    nav.appendChild(ul);
                    const pagination = document.getElementById("pagination");
                    pagination.appendChild(nav);
                }
            }
        }
    };
    request.open('POST', './functions/getTruckMaintenance.php');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("idTruck=" + truck);
}

function update(id) {
    const input = document.getElementById("idTruckUpload");
    input.value = id;
}
setInterval(refreshTable, 60000);
window.onload = refreshTable;
