<!DOCTYYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Index</title>

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
    <script src="jsutils.js"></script>

</head>
<body>

<?php
ob_start();
include 'templates/menuTemplate.php';
echo ob_get_clean();

?>

<div class="ui vertical container">
    <div class="ui relaxed padded divided grid">
        <div class="four wide column">
            <div class="ui vertical large menu" style="margin-top: 15px;">
                <a id="library-menu" class="item">
                    Library
                </a>
                <div id="shelves-menu" class="ui dropdown item">
                    Shelves
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <?php
                        include "DB.php";
                        $db = new DB();
                        list($n_rows, $result) = $db->selectById("SHELF", "USERID", $_SESSION['user']);
                        for ($i = 0; $i < $n_rows; $i++) {
                            echo "<a id=\"shelf-menu-" . $result['SHELFID'][$i] . "\" class=\"item\">" . $result['SHELFNAME'][$i] . "</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="eight wide column">
            <div id="library-page-content">

            </div>
        </div>
        <div class="four wide column">
            <div id="user-library-title"></div>
        </div>
    </div>

</div>


<footer class="footer-basic-centered">

    <p class="footer-company-motto">The company motto.</p>

    <p class="footer-links">
        <a href="#">Home</a>
        ·
        <a href="#">Blog</a>
        ·
        <a href="#">Pricing</a>
        ·
        <a href="#">About</a>
        ·
        <a href="#">Faq</a>
        ·
        <a href="#">Contact</a>
    </p>

    <p class="footer-company-name">Company Name &copy; 2015</p>

</footer>

<div id="modal-content"></div>

<style>
    .slick-prev:before, .slick-next:before {
        color: black !important;
    }

    .ui.dropdown .remove.icon {
        font-size: 0.857143em;
        float: left;
        margin: 0;
        padding: 0;
        left: -0.7em;
        top: 0;
        position: relative;
        opacity: 0.5;
    }

    .ui.dropdown input[value=''] ~ .remove.icon, .ui.dropdown input:not([value]) ~ .remove.icon {
        opacity: 0.0;
    }

</style>

</body>
</html>


