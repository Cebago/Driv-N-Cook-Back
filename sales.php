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
            let chart = new CanvasJS.Chart("salesDiv", {
                animationEnabled: true,
                exportEnabled: true,
                title:{
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
                    dataPoints: <?php echo phpSales(); ?>
                }]
            });
            chart.render();
        }
        window.onload = jsSales;
        setInterval(jsSales, 300000);
    </script>
    <div id="salesDiv" class="w-75 mx-auto"></div>
    <?php include 'footer.php'; ?>
</body>
