<?php
session_start();
require 'conf.inc.php';
require 'functions.php';
include 'header.php';
?>
</head>
<body>
<?php include "navbar.php"; ?>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row" id="ingredients">
        </div>
    </div>
</div>
<script>
    function getIngredients() {
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if(request.readyState === 4) {
                if(request.status === 200) {
                    const myJson = JSON.parse(request.responseText);
                    for (let i = 0; i < myJson.length; i++) {
                        const parent = document.getElementById('ingredients');
                        const div1 = document.createElement('div');
                        const div2 = document.createElement('div');
                        const div3 = document.createElement('div');
                        const div4 = document.createElement('div');
                        const img = document.createElement('img');
                        const p = document.createElement('p');
                        const title = document.createElement('h4');
                        const list = document.createElement('ul');
                        const small = document.createElement('small');
                        div1.className = "col-md-4";
                        div2.className = "card mb-4 shadow-sm";
                        img.src = "img/" + myJson[i]["ingredientImage"];
                        div2.appendChild(img);
                        div3.className = "card-body";
                        title.className = "ml-2"
                        title.innerHTML = myJson[i]["ingredientName"]
                        p.className = "card-text";
                        small.className = "text-muted";
                        if (myJson[i]["warehouses"] === null) {
                            p.innerHTML = "Aucun entrepôt ne possède cet article";
                        } else {
                            const warehouses = Object.keys(myJson[i]["warehouses"]);
                            if (warehouses.length === 1) {
                                p.innerHTML = "Entrepôt :";
                                const li = document.createElement('li');
                                li.innerHTML = warehouses[0];
                                if (Number(myJson[i]["warehouses"][warehouses[0]]) === 1) {
                                    li.innerHTML += " - Article disponible";
                                } else {
                                    li.innerHTML += " - Article non disponible";
                                }
                                list.appendChild(li);
                            } else {
                                p.innerHTML = "Entrepôts :";
                                for (let j = 0; j < warehouses.length; j++) {
                                    const li = document.createElement('li');
                                    li.innerHTML = warehouses[j];
                                    if (Number(myJson[i]["warehouses"][warehouses[j]]) === 1) {
                                        li.innerHTML += " - Article disponible";
                                    } else {
                                        li.innerHTML += " - Article non disponible";
                                    }
                                    list.appendChild(li);
                                }
                            }
                        }
                        small.innerHTML = myJson[i]["ingredientCategory"];
                        div1.id = myJson[i]["idIngredient"];
                        div4.appendChild(small);
                        div3.appendChild(p);
                        div3.appendChild(list);
                        div3.appendChild(div4);
                        div2.appendChild(img);
                        div2.appendChild(title);
                        div2.appendChild(div3);
                        div1.appendChild(div2);
                        parent.appendChild(div1);
                    }
                }
            }
        };
        request.open('POST', 'functions/getIngredients.php');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send();
    }

    window.onload = getIngredients;
</script>


<?php include 'footer.php' ;?>
</body>
