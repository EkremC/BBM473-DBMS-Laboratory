<?php

if (isset($_POST['book_id']) && !empty($_POST['book_id'])) {
    include '../DB.php';
    $db = new DB();

    $book_id = $_POST['book_id'];
    list($n_row_book, $result_book) = $db->selectById('BOOK_USERVIEW', 'BOOKID', $book_id);
    list($n_row_category, $result_category) = $db->selectById('BOOKCATEGORY_VIEW', 'BOOKID', $book_id);
    list($n_row_author, $result_author) = $db->selectById('BOOKAUTHOR_VIEW', 'BOOKID', $book_id);


    $author_format = "<a class=\"ui basic label\">%s</a>";
    $authors = "";
    for ($i = 0; $i < $n_row_author; $i++) {
        $author_name = ucwords(strtolower($result_author['AUTHOR_NAME'][$i]));
        $author_name = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $author_name);
        $authors .= sprintf($author_format, $author_name);
    }

    $category_format = "<a class=\"ui red label\">%s</a>";
    $categories = "";
    for ($i = 0; $i < $n_row_category; $i++) {
        $categories .= sprintf($category_format, strtolower($result_category['CATEGORY_NAME'][$i]));
    }

    $actions = $_POST['actions'] == 0 ? "" : "
    <div class=\"actions\">
        <div class=\"ui orange right labeled icon button\" onclick='userAddEbookModal%s'>
            Add Ebook
            <i class=\"book icon\"></i>
        </div>
        <div class=\"ui green right labeled icon button\" onclick='userAddAudiobookModal%s'>
            Add Audiobook
            <i class=\"music icon\"></i>
        </div>
    </div>
    ";

    $item_format = "<div class=\"ui modal\">
                        <i class=\"close icon\"></i>
                        <div class=\"header\">
                            %s
                        </div>
                        <div class=\"image content\">
                            <div class=\"ui massive image\">
                                <img src=\"https://cdn.waterstones.com/bookjackets/large/9780/0074/9780007448036.jpg\">
                            </div>
                            <div class=\"description\">
                                <div class='ui grid'>
                                    <div class='row'>
                                        <div class=\"ui header\">Summary</div>                            
                                        <p>%s</p>
                                    </div>
                                    <div class='row'>
                                        <ul style='list-style-type: none; margin: 0; padding: 0;'>
                                            <li><div class=\"ui header\" style='margin-bottom: 10px;'>Author(s)</div></li>
                                            <li><div style=''>%s</div></li>
                                        </ul>
                                    </div>
                                    <div class=\"ui divided divider\"></div>
                                    <div class='row'>
                                        %s
                                    </div>
                                </div>
                            </div>
                        </div>
                        " . $actions . "
                    </div>";
    $on_click = '(' . $book_id . ')';
    $item_html = sprintf($item_format, $result_book['BOOKNAME'][0], $result_book['BOOK_SUMMARY'][0], $authors, $categories, $on_click, $on_click);
    echo $item_html;
}