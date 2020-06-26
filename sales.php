<?php
session_start();
include 'header.php';
require 'conf.inc.php';
require 'functions.php'; ?>
</head>
<body>
<?php include 'navbar.php'; ?>
<script>
    function jsSales() {
        const request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState === 4) {
                if (request.status === 200) {

                    let chart = new CanvasJS.Chart("salesDiv", {
                        animationEnabled: true,
                        exportEnabled: true,
                        title: {
                            text: "Répartition du chiffre d'affaires par franchisé"
                        },
                        subtitles: [{
                            text: "Devise utilisée: Euro (€)"
                        }],
                        data: [{
                            type: "pie",
                            showInLegend: "true",
                            legendText: "{label}",
                            indexLabelFontSize: 16,
                            indexLabel: "{label} - #percent%",
                            yValueFormatString: "#.##€",
                            dataPoints: JSON.parse(request.responseText)
                        }]
                    });
                    chart.render();
                }
            }
        };
        request.open('GET', 'functions/getSales.php');
        request.send();
    }

    window.onload = jsSales;
    setInterval(jsSales, 300000);
</script>
<div id="salesDiv" class="w-75 mx-auto"></div>
<?php include 'footer.php'; ?>
</body>
