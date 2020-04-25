<?php
session_start();
require "conf.inc.php";
require "functions.php";
include "header.php";
?>
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="col-md-11 mx-auto mt-3">
        <div class="" role="document">
            <h5 class="" id="updateTruckInfo">Consulation du le camion</h5>
        </div>
            <div class="mt-5" id="profile">
                <div class="input-group flex-nowrap mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="km">Nombre de kilomètres</span>
                    </div>
                    <input type="number" id="updateKM" class="form-control truck" name="km" placeholder="Kilomètres parcourus" aria-label="truckId" aria-describedby="addon-wrapping">
                </div>
            </div>
        </div>
    </div>
    <script>
        function getProfileDetails() {
            const profile = document.getElementById('profile');

            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if(request.readyState === 4) {
                    if(request.status === 200) {
                        //console.log(request.responseText);
                        let myJson = JSON.parse(request.responseText);
                        console.log(myJson);
                        let myJsonKeys = Object.keys(myJson[0])
                        for (let i = 0; i < myJsonKeys.length; i++) {
                            if (myJson[0][myJsonKeys[i]] !== null) {
                                //console.log(myJsonKeys[i] + " = " + myJson[0][myJsonKeys[i]]);
                                let pdiv = document.createElement("div");
                                let cdiv = document.createElement("div");
                                let span = document.createElement("span");
                                let input = document.createElement("input");

                                pdiv.className = "input-group flex-nowrap mt-1";
                                cdiv.className = "input-group-prepend";
                                span.id = myJsonKeys[i];
                                span.className = "input-group-text";
                                if (myJsonKeys[i] === "idUser") {

                                } else if (myJsonKeys[i] === "emailAddress") {

                                } else if (myJsonKeys[i])
                                span.innerHTML = myJsonKeys[i];
                                cdiv.appendChild(span);
                                pdiv.appendChild(cdiv);
                                input.id = myJsonKeys[i];
                                input.className = "form-control";
                                input.placeholder = myJsonKeys[i];
                                input.value = myJson[0][myJsonKeys[i]];
                                pdiv.appendChild(input);
                                profile.appendChild(pdiv);
                                console.log(myJsonKeys[i]);
                            }
                        }
                    }
                }
            };
            request.open('GET', 'functions/profilDetails.php');
            request.send();
        }
        window.onload = getProfileDetails;
    </script>
    <?php include "footer.php"; ?>
</body>