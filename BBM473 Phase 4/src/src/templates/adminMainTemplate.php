<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/alertifyjs/1.10.0/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/alertifyjs/1.10.0/css/themes/semantic.min.css"/>

    <!-- FOOTER -->
    <link rel="stylesheet" href="footer-basic-centered.css">


    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js "></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.0/jquery-migrate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-serialize-object/2.5.0/jquery.serialize-object.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.js"></script>
    <script src="//cdn.jsdelivr.net/alertifyjs/1.10.0/alertify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="jsutils.js"></script>
</head>
<body onload="listTable('tables/statisticstable.php')">
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
        <div class="right item">
            <a class="ui orange label" style="height: 33px;">
                <img class="ui right avatar image" src="http://1.semantic-ui.com/images/home-avatar.png">
                <?php
                @session_start();
                if (!isset($_SESSION["login"])) {
                    header("Location:index.php");
                } else {
                    $username = $_SESSION['username'];
                    echo $username;
                }
                ?>
            </a>
            <button id="logout-button" class="ui compact icon red button"
                    style="margin-left: 20px; font-size: 12px !important; height: 33px;">
                <span style="margin-right: 10px;">Sign Out</span>
                <i class="sign out icon"></i>
            </button>
        </div>

    </div>
</div>
<div class="ui vertical container">
    <div class="ui relaxed padded divided grid">
        <div class="four wide column">
            <div class="ui vertical menu">
                <div class="item">
                    <div class="header">System Monitoring</div>
                    <div class="menu">
                        <a class="active item admin-menu"
                           onclick="listTable('tables/statisticstable.php')">Statistics</a>
                        <a class="item admin-menu" onclick="listTable('tables/logtbltable.php')">System Logs</a>
                    </div>
                </div>
                <div class="item">
                    <div class="header">Books</div>
                    <div class="menu">
                        <a class="item admin-menu" onclick="listTable('tables/booktable.php')">Book</a>
                        <a class="item admin-menu" onclick="listTable('tables/authortable.php')">Author</a>
                        <a class="item admin-menu" onclick="listTable('tables/publishertable.php')">Publisher</a>
                        <a class="item admin-menu" onclick="listTable('tables/categorytbltable.php')">Category</a>
                        <a class="item admin-menu" onclick="listTable('tables/ebooktable.php')">E-book</a>
                        <a class="item admin-menu" onclick="listTable('tables/audiobooktable.php')">Audio-book</a>
                    </div>
                </div>
                <div class="item">
                    <div class="header">Administration</div>
                    <div class="menu">
                        <a class="item admin-menu" onclick="listTable('tables/systemusertable.php')">System Users</a>
                        <a class="item admin-menu" onclick="listTable('tables/rolestable.php')">Roles</a>
                        <a class="item admin-menu" onclick="listTable('tables/permissionstable.php')">Permissions</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="twelve wide column">
            <div id="admin-middle-content">

            </div>
            <button onclick="exportFile(0)" class="ui black button">
                <i class="file text outline icon"></i>Text
            </button>
            <button onclick="exportFile(1)" class="ui blue button">
                <i class="file outline icon"></i>Html
            </button>
            <button onclick="exportFile(2)" class="ui red button">
                <i class="file pdf outline icon"></i>Pdf
            </button>
        </div>
    </div>
</div>

</body>
</html>