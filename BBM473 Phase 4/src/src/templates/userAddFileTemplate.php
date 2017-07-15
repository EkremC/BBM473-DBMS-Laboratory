<?php

if (isset($_POST['book_id']) && !empty($_POST['book_id'])) {
    session_start();
    include '../DB.php';
    $db = new DB();

    $book_id = $_POST['book_id'];
    $book_name = $db->selectById('BOOK_USERVIEW', 'BOOKID', $book_id)[1]['BOOKNAME'][0];
    $user = $_SESSION['user'];

    if ($_POST['mode'] == 'ebook') {

        list($n_rows_ebook, $result_ebook) = $db->selectById('EBOOK_VIEW', 'BOOKID', $book_id);
        list($n_rows_shelf, $result_shelf) = $db->selectById('SHELF', 'USERID', $user);

        $table_content = $n_rows_ebook > 0 ?
        "
        <table class=\"ui compact celled table\" id='add-file-table'>
            <thead>
            <tr>
                <th>Publisher</th>
                <th>Publish Date</th>
                <th>Number of Pages</th>
                <th>Select Shelf</th>
            </tr>
            </thead>
            <tbody>                    
                %s
            </tbody>
        </table>
        " : "
        <div class=\"ui negative message\">
            <div class=\"header\">
                There is no available audiobook for this book.
            </div>
            <p id=\"error-message\"></p>
        </div>
        ";
        $table = " 
        <i class=\"close icon\"></i>
        <div class=\"header\">
            %s
        </div>
        <div class=\"content\">
            <div class=\"description\">
                <div class=\"ui header\">Select ebooks you want to add</div>
                <p>
                " . $table_content . "
                </p>
            </div>
        </div>
        <div class=\"actions\">
            <div class=\"ui orange right labeled icon button\" onclick='userAddFile(\"ebook\")'>
                Add Selected Ebooks
                <i class=\"book icon\"></i>
            </div>
        </div>";


        $row_format = "
        <tr>                        
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td class='book-add-cell'>%s</td>
        </tr>  
        ";

        $shelves_format = "
        <input class='file-id' type='hidden' value='%s'/>
        <div class=\"ui selection dropdown\">
            <input name=\"tags\" type=\"hidden\">
            <i class=\"dropdown icon\"></i>
            <i class=\"remove icon\"></i>
            <div class=\"default text\">Select</div>
            <div class=\"menu\">
                %s
            </div>
        </div>
        ";

        $dropdown_item = "<div class=\"item\" data-value=\"%s\">%s</div>";

        $dropdown = "<div class=\"item\" data-value=\"-1\">Library</div>";
        for ($i = 0; $i < $n_rows_shelf; $i++) {
            $dropdown .= sprintf($dropdown_item, $result_shelf['SHELFID'][$i], $result_shelf['SHELFNAME'][$i]);
        }

        $rows = "";
        for ($i = 0; $i < $n_rows_ebook; $i++) {
            $shelfs = sprintf($shelves_format, $result_ebook['FILEID'][$i], $dropdown);
            $rows .= sprintf($row_format, $result_ebook['PUBLISHER'][$i], $result_ebook['PUBLISH_DATE'][$i],
                $result_ebook['PAGE_NUMBER'][$i], $shelfs);
        }

        echo sprintf($table, $book_name, $rows);
    } else {

        list($n_rows_audiobook, $result_audiobook) = $db->selectById('AUDIOBOOK_VIEW', 'BOOKID', $book_id);
        list($n_rows_shelf, $result_shelf) = $db->selectById('SHELF', 'USERID', $user);

        $table_content = $n_rows_audiobook > 0 ? "
        <table class=\"ui compact celled table\" id='add-file-table'>
            <thead>
            <tr>
                <th>Publisher</th>
                <th>Publish Date</th>
                <th>Number of Pages</th>
                <th>Duration</th>
                <th>Select Shelf</th>
            </tr>
            </thead>
            <tbody>                    
                %s
            </tbody>
        </table>
        " :
        "            
        <div class=\"ui negative message\">
            <div class=\"header\">
                There is no available audiobook for this book.
            </div>
            <p id=\"error-message\"></p>
        </div>";

        $table = " 
        <i class=\"close icon\"></i>
        <div class=\"header\">
            %s
        </div>
        <div class=\"content\">
            <div class=\"description\">
                <div class=\"ui header\">Select audiobooks you want to add</div>
                <p>
                " . $table_content . "
                </p>
            </div>
        </div>
        <div class=\"actions\">
            <div class=\"ui orange right labeled icon button\" onclick='userAddFile(\"audiobook\")'>
                Add Selected Audiobooks
                <i class=\"music icon\"></i>
            </div>
        </div>";


        $row_format = "
        <tr>                        
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td class='book-add-cell'>%s</td>
        </tr>  
        ";

        $shelves_format = "
        <input class='file-id' type='hidden' value='%s'/>
        <div class=\"ui selection dropdown\">
            <input name=\"tags\" type=\"hidden\">
            <i class=\"dropdown icon\"></i>
            <i class=\"remove icon\"></i>
            <div class=\"default text\">Select</div>
            <div class=\"menu\">
                %s
            </div>
        </div>
        ";

        $dropdown_item = "<div class=\"item\" data-value=\"%s\">%s</div>";

        $dropdown = "<div class=\"item\" data-value=\"-1\">Library</div>";
        for ($i = 0; $i < $n_rows_shelf; $i++) {
            $dropdown .= sprintf($dropdown_item, $result_shelf['SHELFID'][$i], $result_shelf['SHELFNAME'][$i]);
        }

        $rows = "";
        for ($i = 0; $i < $n_rows_audiobook; $i++) {
            $shelfs = sprintf($shelves_format, $result_audiobook['FILEID'][$i], $dropdown);
            $rows .= sprintf($row_format, $result_audiobook['PUBLISHER'][$i], $result_audiobook['PUBLISH_DATE'][$i],
                $result_audiobook['PAGE_NUMBER'][$i], $result_audiobook['TOTAL_DURATION'][$i], $shelfs);
        }

        echo sprintf($table, $book_name, $rows);
    }


}