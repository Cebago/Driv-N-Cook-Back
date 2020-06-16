function warehouseDisplay() {
    const select = document.getElementById("selectWarehouse");
    if (select[0].innerText === "Choisir un entrepôt ...") {
        select.removeChild(select[0]);
    }
    const list = document.getElementById("warehouseList");
    while (list.firstChild) {
        list.removeChild(list.firstChild);
    }

    let option = select.options[select.selectedIndex].text
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                let myJson = JSON.parse(request.responseText);
                console.log(myJson);
                if (myJson.length === 0) {
                    const container = document.getElementById("warehousePourcentage");
                    container.innerText = "Entrepôt vide"
                } else {
                    let chart = new CanvasJS.Chart("warehousePourcentage", {
                        theme: "light2",
                        animationEnabled: true,
                        title: {
                            text: "Pourcentage d'ingrédients différents - " + option
                        },
                        data: [{
                            type: "pie",
                            indexLabel: "{y}",
                            yValueFormatString: "#,##0.00\"%\"",
                            indexLabelPlacement: "inside",
                            indexLabelFontColor: "#36454F",
                            indexLabelFontSize: 18,
                            indexLabelFontWeight: "bolder",
                            showInLegend: true,
                            legendText: "{label}",
                            dataPoints: myJson
                        }]
                    });
                    chart.render();
                    const ulP = document.createElement("ul");
                    for (let i = 0; i < myJson.length; i++) {
                        const liP = document.createElement("li");
                        liP.innerText = myJson[i]["label"];
                        const ulC = document.createElement("ul");
                        for (let j = 0; j < myJson[i]["ingredientList"].length; j++) {
                            const liC = document.createElement("li");
                            liC.innerText = myJson[i]["ingredientList"][j]["ingredientName"]
                            if (Number(myJson[i]["ingredientList"][j]["available"]) === 1) {
                                liC.innerText += " - Disponible"
                            } else {
                                liC.innerText += " - Indisponible"
                            }
                            ulC.appendChild(liC);
                        }
                        liP.appendChild(ulC);
                        ulP.appendChild(liP);
                    }
                    list.appendChild(ulP);
                }
            }
        }
    };
    request.open('GET', './functions/getWarehouseData.php?id=' + select.value);
    request.send();

}