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
            <!--<div class="ui vertical pointing menu">-->
            <div id="filter-container">
                <?php
                $category_ids = isset($_GET['category']) ? explode(",", $_GET['category']) : array("");
                $author_ids = isset($_GET['author']) ? explode(",", $_GET['author']) : array("");
                $publisher_ids = isset($_GET['author']) ? explode(",", $_GET['publisher']) : array("");

                include "templates/filterTemplate.php";
                $filter = new Filter();
                echo $filter->getFilterSelected($category_ids, $author_ids, $publisher_ids);
                ?>
            </div>
            <div id="filter-button" class="ui bottom attached blue button">Filter</div>
            <!--</div> -->
        </div>

        <div class="ten wide column">

            <div class="ui relaxed divided items">
                <?php
                $db = new DB();

                $category_sql = "";
                $author_sql = "";
                $publisher_sql = "";

                $default_sql = "
                    SELECT DISTINCT BOOKID, BOOKNAME 
                    FROM BOOK
                    ";

                if ($category_ids[0] != "") {
                    $category_sql_format = "
                        SELECT DISTINCT BOOKID, BOOKNAME 
                        FROM BOOKCATEGORY_VIEW WHERE CATEGORYID = %s
                        ";

                    for ($i = 0; $i < count($category_ids); $i++) {
                        $category_sql .= sprintf($category_sql_format, $category_ids[$i]);
                        if ($i != count($category_ids) - 1) {
                            $category_sql .= " UNION ";
                        }
                    }
                } else {
                    $category_sql = $default_sql;
                }

                if ($author_ids[0] != "") {
                    $author_sql_format = "
                        SELECT DISTINCT BOOKID, BOOKNAME 
                        FROM BOOKAUTHOR_VIEW WHERE AUTHORID = %s
                        ";

                    for ($i = 0; $i < count($author_ids); $i++) {
                        $author_sql .= sprintf($author_sql_format, $author_ids[$i]);
                        if ($i != count($author_ids) - 1) {
                            $author_sql .= " UNION ";
                        }
                    }
                } else {
                    $author_sql = $default_sql;
                }

                if ($publisher_ids[0] != "") {
                    $publisher_sql_format = "
                        SELECT DISTINCT BOOKID, BOOKNAME 
                        FROM FILE_ADMINVIEW WHERE PUBLISHERID = %s
                        ";

                    for ($i = 0; $i < count($publisher_ids); $i++) {
                        $publisher_sql .= sprintf($publisher_sql_format, $publisher_ids[$i]);
                        if ($i != count($publisher_ids) - 1) {
                            $publisher_sql .= " UNION ";
                        }
                    }
                } else {
                    $publisher_sql = $default_sql;
                }

                $book = "
                    <div class=\"item\">
                        <a class=\"ui tiny rounded image\" onclick='%s'>
                            <img class='ui image hoverZoomLink' src=\"https://www.teachprivacy.com/wp-content/uploads/Orwell-1984-Book-Cover-02.jpg\">
                        </a>
                        <div class=\"middle aligned content\">
                            <a class=\"header\" onclick='%s'>%s</a>
                            <div class=\"meta\">
                                <div class=\"ui horizontal list\">
                                %s
                                </div>
                            </div>
                            <div class=\"extra\">
                                <a class=\"ui label\" onclick='%s'><i class=\"expand icon\"></i>Details</a>
                            </div>
                        </div>
                    </div>
                    ";

                $author = "<div class=\"item\">
                                <div class=\"content\">
                                    <a class=\"header\" onclick='%s'>%s</a>
                                </div>
                              </div>";

                $result_sql = $category_sql . " INTERSECT " . $author_sql . " INTERSECT " . $publisher_sql;
                list($n_row, $result) = $db->executeQuery($result_sql);
                list($n_row_author, $result_author) = $db->selectAll('BOOKAUTHOR_VIEW');

                $action = $_SESSION['admin'] == true ? 0 : 1;
                for ($i = 0; $i < $n_row; $i++) {

                    $onclick = "showBookContent(" . $result['BOOKID'][$i] . ", " . $action . ")";
                    $authors = "";
                    for ($j = 0; $j < $n_row_author; $j++) {
                        if ($result['BOOKID'][$i] == $result_author['BOOKID'][$j]) {
                            $authors .= sprintf($author, $onclick, $result_author['AUTHOR_NAME'][$j]);
                        }
                    }
                    echo sprintf($book, $onclick, $onclick, $result["BOOKNAME"][$i], $authors, $onclick);
                }

                ?>

            </div>

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

</body>
</html>




