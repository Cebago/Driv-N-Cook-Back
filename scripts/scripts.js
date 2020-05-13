var map;
var marker;

function init1truck(myLoc, name) {
    marker = new google.maps.Marker({
        position: myLoc,
        icon : 'img/truck.png'
    });

    var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h3>'+name+'</h3>'+
        '<div id="bodyContent">'+
        '</div>';

    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });


    let opt = {
        center: myLoc,
        zoom: 13 ,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("mapAllTrucks"), opt);
    marker.setMap(map);
    marker.addListener('mouseover', function() {
        infowindow.open(map, marker);
    });


}




function showMap(idTruck) {

    let opt = {
        center: new google.maps.LatLng(48.8376962,2.3896693),
        zoom: 8 ,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapAllTrucks"), opt);

    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                if (request.responseText !== "") {
                    let myJson = JSON.parse(request.responseText);
                    for (var i = 0; i < myJson.length; i++) {
                        let marker = new google.maps.Marker({
                            position: new google.maps.LatLng(myJson[i]["lat"], myJson[i]["lng"]),
                            icon: 'img/truck.png',
                            map: map
                        });
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

                        let largeInfoString = '<div id="content" class="dataInfos">' +
                            '<div id="siteNotice">' +
                            '</div>' +
                            '<h5>' + myJson[i]["truckName"] + '</h5>' +
                            '<div id="bodyContent">' +
                            '<div><b>'+  myJson[i]["truckManufacturers"] +' '+ myJson[i]["truckModel"] + ' </b></div>' +
                            '<div>'+  myJson[i]["km"] +' Kiliomètres parcourus</div>' +
                            '<div>Créé le '+  myJson[i]["createDate"] +'</div>' +
                            '<div>Double cliquer pour accéder à la page du camion</div>' +
                            '</div>';

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
                                'http://drivncook.fr',
                                '_blank' 
                            );
                        });
                    }
                }
            }
        }
        return 0;
    };
    request.open('GET', 'functions/getTruckPos.php');
    request.send();

};

function refreshTable() {
    const content = document.getElementById("tablebody");

    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
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
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
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
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
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
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                let truckJson = JSON.parse(request.responseText);
                const truck = document.getElementsByClassName("truck");
                for (let i = 0; i < truck.length; i++) {
                    const input = document.getElementsByName(truck[i].name);;
                    input[0].value = truckJson[0][truck[i].name];
                }
            }
        }
    };
    request.open('GET', './functions/getTruckInfo.php?id='+idtruck, true);
    request.send();
}

function createTruck() {
    const manufacturers = document.getElementById("truckManufacturers").value;
    const model = document.getElementById("truckModel").value;
    const license = document.getElementById("licensePlate").value;
    const km = document.getElementById("truckKm").value;
    const warehouse = document.getElementById("truckWarehouse").value;

    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                console.log(request.responseText);
            }
        }
    };
    request.open('POST', 'functions/createTruck.php');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(
        'manufacturers=' + manufacturers +
        '&model=' + model +
        '&license=' + license +
        '&km=' + km +
        '&warehouse=' + warehouse
    );
    setTimeout(refreshTable, 1000);
}
function getOpenDays(idtruck) {
    const table = document.getElementById("tableBody");
    table.innerText = "";

    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
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
                            const td1 = document.createElement("td");
                        td1.innerText = myJson[i]["startHour"];
                        td1.className = "text-center";
                        const td2 = document.createElement("td");
                        td2.innerText = myJson[i]["endHour"];
                        td2.className = "text-center";

                        tr.appendChild(thd);
                        tr.appendChild(td1);
                        tr.appendChild(td2);
                    } else {

                        search.setAttribute("rowspan", "2");
                        search.className = "align-middle";
                        const td1 = document.createElement("td");
                        td1.innerText = myJson[i]["startHour"];
                        td1.className = "text-center";
                        const td2 = document.createElement("td");
                        td2.innerText = myJson[i]["endHour"];
                        td2.className = "text-center";
                        tr.appendChild(td1);
                        tr.appendChild(td2);
                    }
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
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
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

setInterval(refreshTable, 60000);
window.onload = refreshTable;