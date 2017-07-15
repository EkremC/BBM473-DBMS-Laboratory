<?php
@session_start();
?>
<div class="ui attached stackable menu">
    <div class="ui container">

        <a class="item" href="main.php">
            <i class="home icon"></i> Home
        </a>
        <a class="item" href="filter.php">
            <i class="list icon"></i> Browse
        </a>
        <a class="item" href="userProfile.php">
            <i class="user icon"></i> Profile
        </a>
        <?php
            if ($_SESSION['admin'] != true) {
                echo "<a class=\"item\" href=\"library.php\">
                        <i class=\"book icon\"></i> My Library
                    </a>";
            }
        ?>
        <div class="right item">
            <a class="ui orange label" style="height: 33px;">
                <img class="ui right avatar image" src="http://1.semantic-ui.com/images/home-avatar.png">
                <?php

                if (!isset($_SESSION["login"])) {
                    header("Location:index.php");
                } else {
                    $username = $_SESSION['username'];
                    echo $username;
                }
                ?>
            </a>
            <button id="logout-button" class="ui compact icon red button" style="margin-left: 20px; font-size: 12px !important; height: 33px;">
                <span style="margin-right: 10px;">Sign Out</span>
                <i class="sign out icon"></i>
            </button>
        </div>

    </div>
</div>