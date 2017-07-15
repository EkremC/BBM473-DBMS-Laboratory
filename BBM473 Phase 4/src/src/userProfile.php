<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Profile</title>

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
            <div class="ui fluid card">
                <div class="image">
                    <img src="http://1.semantic-ui.com/images/home-avatar.png">
                </div>
                <div class="content">
                    <a class="header">
                        <?php

                        $firstname = $_SESSION['firstname'];
                        $lastname = $_SESSION['lastname'];
                        echo $firstname . " " . $lastname;
                        ?></a>
                </div>
            </div>
            <div class="ui grid">
                <div class="row">
                    <div class="column">
                        <div class="ui large label">
                            <i class="book icon"></i>
                            Library

                            <?php
                            include 'DB.php';
                            $user = $_SESSION["user"];
                            $db = new DB();
                            list($n_rows_shelf, $result_shelf) = $db->selectById('LIBRARYTBL', 'USERID', $user);
                            echo $n_rows_shelf;
                            ?>

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="column">

                        <?php
                        //include 'DB.php';
                        $db = new DB();
                        $user = $_SESSION["user"];
                        list($n_rows_shelf, $result_shelf) = $db->selectById('SHELF', 'USERID', $user);
                        $shelves_format = "
                              <input class='file-id' type='hidden' />
                              <div class=\"ui selection dropdown\" id=\"user-shelf-id\">
                                 <input name=\"tags\" type=\"hidden\">
                                 <i class=\"dropdown icon\"></i>
                                 <div class=\"default text\">Shelfs</div>
                                 <div class=\"menu\" >
                                    %s
                                </div>
                            </div>
                            ";
                        $dropdown_item = "<div class=\"item\" data-value=\"%s\">%s</div>";

                        $dropdown = "";
                        for ($i = 0; $i < $n_rows_shelf; $i++) {
                            $dropdown .= sprintf($dropdown_item, $result_shelf['SHELFID'][$i], $result_shelf['SHELFNAME'][$i]);
                        }

                        $shelves = sprintf($shelves_format, $dropdown);

                        echo $shelves;
                        ?>
                        <div class="ui button" style="margin-top: 5px; margin-left: 20px;" onclick="getSelectedTextValue()">
                            Bring My Shelf!

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="eight wide column">
            <div>
                <h3 style="color: lightgray">Library</h3>
            </div>
            <div class="ui cards" id="user-library" style="height: 339px; margin-top: 15px; margin-bottom: 15px;">

                <?php
                $item_format = "<div style='padding-right: 10px; padding-left: 10px;'>
                <div class='ui fluid card' style='width: 160px; height: 338px;'>

                    <a class='image' href='#' onclick='%s'>

                        <img src='%s' class='ui image hoverZoomLink' style='height: auto; width: 160px;'>

                    </a>
                    <div class='content'>
                        <a class='header' href='#' style='font-size:16px;'onclick='%s'>%s</a>
                        <div class='meta'>
                            <a>Published by %s</a>
                        </div>
                    </div>
                </div>
            </div>";

                $db = new DB();
                $userid = $_SESSION["user"];

                list($n_rows, $result) = $db->selectById('USER_LIBRARY_VIEW', "USERID", $userid);


                //echo $n_rows;

                for ($i = 0; $i < $n_rows; $i++) {
                    $row = array();
                    foreach ($result as $col) {
                        array_push($row, $col[$i]);
                    }
                    $on_click = 'showBookContent(' . $result['BOOKID'][$i] . ', 0); return false;';
                    $item = sprintf($item_format, $on_click, 'http://ecx.images-amazon.com/images/I/61gQLALjWsL._SX326_BO1,204,203,200_.jpg',
                        $on_click, $result['BOOKNAME'][$i], $result['PUBLISHER_NAME'][$i]);
                    echo $item;
                }
                ?>

            </div>
            
                <div>
                    <h3 style="color: lightgray">Shelf</h3>
                </div>
                <div id="user-shelf">

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

//$username = $_SESSION['username'];
//echo "string". $username;
?>

</body>
</html>