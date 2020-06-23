<?php
session_start();
require 'conf.inc.php';
require 'functions.php';

if (isAdmin() && isActivated() && isConnected()) {
include 'header.php';
?>
    </head>

    <body>
    <?php include 'navbar.php'; ?>
    list of all newsletter
    <?php include 'footer.php'; ?>
    </body>
    <?php
} else {
    header("Location: login.php");
}
?>
