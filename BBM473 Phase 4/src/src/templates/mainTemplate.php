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
include 'menuTemplate.php';
echo ob_get_clean();

?>

<div class="ui vertical container">
    <div class="ui relaxed padded divided grid">

        <div class="four wide column">
            <!--<div class="ui vertical pointing menu">-->
            <div id="filter-container">
                <?php
                include "filterTemplate.php";
                $filter = new Filter();
                echo $filter->getFilter();
                ?>
            </div>
            <div id="filter-button" class="ui bottom attached blue button">Filter</div>
            <!--</div> -->
        </div>

        <div class="ten wide column">
            <div>
                <h3 style="color: lightgray">Most Read</h3>
            </div>
            <div class="ui cards" id="most-read-books" style="height: 335px; margin-top: 15px; margin-bottom: 15px;">
                <?php
                $item_format = "<div style='padding-right: 10px; padding-left: 10px;'>
                                    <div class='ui fluid card' style='width: 150px; height: 330px;'>
                                        <a class='image' href='#' onclick='%s'>
                                            <img src='%s' class='ui image hoverZoomLink' style='height: auto; width: 150px;'>
                                        </a>
                                        <div class='content'>
                                            <a class='header' href='#' onclick='%s'>%s</a>
                                            <div class='meta'>
                                                <a>Read by %s users</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";

                $db = new DB();

                list($n_rows, $result) = $db->selectAll('BOOK_ADDINGNUMBER_VIEW');

                for ($i = 0; $i < $n_rows; $i++) {
                    $row = array();
                    foreach ($result as $col) {
                        array_push($row, $col[$i]);
                    }

                    $on_click = 'showBookContent(' . $row[0] . ', 1); return false;';
                    $item = sprintf($item_format, $on_click,
                        'https://cdn.waterstones.com/bookjackets/large/9780/0074/9780007448036.jpg',
                        $on_click, $row[1], $row[3]);
                    echo $item;
                }


                ?>
            </div>
            <div class="ui divided divider"></div>
            <div style="margin-top: 20px;">
                <h3 style="color: lightgray">Authors</h3>
            </div>
            <div class="ui cards" id="authors" style="height: 305px; margin-top: 15px;">
                <?php
                $item_format = "<div style='padding-right: 10px; padding-left: 10px;'>
                                    <div class='ui fluid card' style='width: 150px; height: 300px;'>
                                        <a class='image' href='#' onclick='%s'>
                                            <img src='%s' class='ui image hoverZoomLink' style='height: auto; width: 150px;'>
                                        </a>
                                        <div class='content'>
                                            <a class='header' href='#' onclick='%s'>%s</a>
                                            <div class='meta'>
                                                <a>In %s user libraries</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";

                $db = new DB();

                list($n_rows, $result) = $db->selectAll('AUTHOR_MOSTLIBRARY_VIEW');

                for ($i = 0; $i < $n_rows; $i++) {
                    $on_click = 'showAuthorContent(' . $result['AUTHORID'][$i] . '); return false;';
                    $item = sprintf($item_format, $on_click,
                        'https://static01.nyt.com/images/2012/12/18/sports/tennis/18tolkienpic/18tolkienpic-superJumbo.jpg',
                        $on_click, $result['AUTHOR_NAME'][$i], $result['USERNUMBER'][$i]);
                    echo $item;
                }


                ?>
            </div>
            <div style="margin-top: 20px;">
                <h3 style="color: lightgray">Fiction</h3>
            </div>
            <div class="ui cards" id="fiction-books" style="height: 335px; margin-top: 15px;">
                <?php
                $item_format = "<div style='padding-right: 10px; padding-left: 10px;'>
            <div class='ui fluid card' style='width: 150px; height: 330px;'>
                <a class='image' href='#' onclick='showBookContent(); return false;'>
                    <img src='%s' class='ui image hoverZoomLink' style='height: auto; width: 150px;'>
                </a>
                <div class='content'>
                    <a class='header' href='#' onclick='showBookContent(); return false;'>%s</a>
                </div>
            </div>
        </div>";

                $db = new DB();

                list($n_rows, $result) = $db->selectAll('FICTION_BOOKS_VIEW');

                for ($i = 0; $i < $n_rows; $i++) {
                    $row = array();
                    foreach ($result as $col) {
                        array_push($row, $col[$i]);
                    }
                    $item = sprintf($item_format, 'http://ecx.images-amazon.com/images/I/61gQLALjWsL._SX326_BO1,204,203,200_.jpg', $row[0]);
                    echo $item;
                }


                ?>
            </div>
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

<!--
<div class="footerContainer" style="position: relative; clear: left; ">
    <div class="footer phdef">
        <ul class="footerMenu">
            <li style="float: left; list-style: none;">
                <ul style="list-style: none; margin-bottom: 5px; margin-top: 5px;">
                    <li><a href="www.facebook.com">Facebook</a></li>
                </ul>
            </li>
            <li style="float: left; list-style: none; margin-bottom: 5px; margin-top: 5px;">
                <ul style="list-style: none;">
                    <li><a href="www.google.com">Google</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
-->

<!--
<div id = "adbl-footer" style="margin-left: 100px;">
    <div class="reg-footer-wide" style="width: 100%">
        <div class="column-section" >
            <div class="col">
                <a href="www.facebook.com">Facebook</a>
                <a href="www.google.com">Google</a>
            </div>
            <div class="col">
                <a href="www.facebook.com">Facebook</a>
                <a href="www.google.com">Google</a>
            </div>
        </div>
    </div>
-->


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

<?php


?>
</body>
</html>


