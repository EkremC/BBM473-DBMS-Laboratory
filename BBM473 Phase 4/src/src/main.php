<?php

include("DB.php");
ob_start();
session_start();

if (!isset($_SESSION["login"])) {
    header("Location:index.php");
} else {
//    echo "Admin page";
//    echo "<a href=logout.php>Guvenli cikis</a></center>";

    if ($_SESSION["admin"] == true) {
        ob_start();
        include 'templates/adminMainTemplate.php';
        echo ob_get_clean();
    } else {
        ob_start();
        include 'templates/mainTemplate.php';
        echo ob_get_clean();
    }
}