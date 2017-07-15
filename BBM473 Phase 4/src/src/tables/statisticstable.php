<div class="ui tiny horizontal statistics">
    <?php
    $statistics = "
<div class=\"ui statistic\">
  <div class=\"value\">
    %s
  </div>
  <div class=\"label\">
    %s
  </div>
</div>";


    $content = "";
    $rows = "";
    $row_one = "
            <tr>
                <td>%s</td>                
            </tr>           
            ";
    $row_two = "
            <tr>
                <td>%s</td>
                <td>%s</td>                
            </tr>           
            ";

    include "../DB.php";
    $db = new DB();
    // TOPLAM COMMERCIAL USER SAYISI
    list($n_rows, $result_user) = $db->selectAll('COMMERCIALUSER_VIEW');
    //    $rows .= sprintf($row_one, "<span><b>Total commercial user </b></span>" . $n_rows);
    $content .= sprintf($statistics, $n_rows, "Total commercial user");

    // EN FAZLA KUTUPHANEDE OLAN YAZAR
    list($n_rows, $result) = $db->selectFirstRow('AUTHOR_MOSTLIBRARY_VIEW');
    //    $rows .= sprintf($row_two, "<span><b>Author</b></span> <span style='float: right'>" . $result['AUTHOR_NAME'][0] . "</span>", "<span><b>Library</b></span>" . $result['USERNUMBER'][0]);
    $content .= sprintf($statistics, $result['AUTHOR_NAME'][0], "Most reading author -> Added in " . $result['USERNUMBER'][0] . " libraries");

    // KUTUPHANESINDE EN COK KITAP OLAN USER'IN KITAP SAYISI VE ADI
    list($n_rows, $result) = $db->selectFirstRow('HAVE_MOST_BOOKS_USER_VIEW');
    $content .= sprintf($statistics, $result['USERNAME'][0], "User with the largest library -> " . $result['FILENUMBER'][0] . " books");

    // EN COK KITABI BULUNAN YAZAR
    list($n_rows, $result) = $db->selectFirstRow('AUTHOR_BOOKNUMBER_VIEW');
    $content .= sprintf($statistics, $result['AUTHOR_NAME'][0], "Author with most books -> " . $result['BOOKNUMBER'][0]);

    // TOPLAM KATEGORİ SAYISI
    list($n_rows, $result) = $db->selectAll('Categorytbl');
    $content .= sprintf($statistics, $n_rows, "Total category number");

    // EN COK KUTUPHANEDE EKLI OLAN KITAP
    list($n_rows, $result) = $db->selectFirstRow('BOOK_ADDINGNUMBER_VIEW');
    $content .= sprintf($statistics, $result['BOOKNAME'][0], "Most added book by users -> In " . $result['USERNUMBER'][0] . "libraries");

    // EN COK KITAP BULUNAN KATEGORI
    list($n_rows, $result) = $db->selectFirstRow('CATEGORY_BOOKNUMBER_VIEW');
    $content .= sprintf($statistics, $result['CATEGORY_NAME'][0], "Category that contains most books -> " . $result['BOOKNUMBER'][0]);

    // EN COK ISLEM GERCEKLESTIREN ADMIN
    list($n_rows, $result) = $db->executeQuery('
SELECT
  USERTBL.USERNAME,
  COUNT(*) COUNT
FROM LOGTBL
  INNER JOIN USERTBL ON LOGTBL.USERID = USERTBL.USERID
GROUP BY USERTBL.USERNAME
ORDER BY COUNT DESC');
    $content .= sprintf($statistics, $result['USERNAME'][0], "Admin that mades most transactions -> " . $result['COUNT'][0]);


    // EN COK YAYIN YAPAN PUBLISHER
    list($n_rows, $result) = $db->selectFirstRow('PUBLISHER_WITHMOSTPUBLISH');
    $content .= sprintf($statistics, $result['PUBLISHER_NAME'][0], "Publisher that has most publications -> " . $result['COUNT'][0]);


    // EN COK SHELFI OLAN USER
    list($n_rows, $result) = $db->selectFirstRow('USER_WITHMOSTSHELF');
    $content .= sprintf($statistics, $result['USERNAME'][0], "User with having most shelves -> " . $result['COUNT'][0]);


    echo $content;
    /*
    for ($i = 0; $i < $n_rows; $i++) {
        echo sprintf($row, $result['AUTHORID'][$i], $result['AUTHORID'][$i], $result['AUTHOR_NAME'][$i], $result['INSERTUSER'][$i]);
    }
    */
    ?>
</div>

<div class="ui modal">
    <i class="close icon"></i>
    <div class="header">

    </div>
    <div class="ui text container" style="padding: 50px; size: 200px;">

    </div>
    <div class="actions">

    </div>
</div>

<style>
    .buttons .button {
        opacity: 0.9;
        width: 90px;
    }

    tr {
        cursor: default;
    }

    .highlight {
        background: #dfe0e1;
    }

</style>

<?php

