<?php

if (isset($_POST['author_id']) && !empty($_POST['author_id'])) {
    include '../DB.php';
    $db = new DB();

    $author_id = $_POST['author_id'];
    list($n_row_author, $result_author) = $db->selectById('AUTHOR', 'AUTHORID', $author_id);
    list($n_row_book, $result_book) = $db->selectById('BOOKAUTHOR_VIEW', 'AUTHORID', $author_id);

    $author_name = ucwords(strtolower($result_author['AUTHOR_NAME'][0]));
    $author_name = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $author_name);

    $author = "<div class=\"ui modal\">
                    <i class=\"close icon\"></i>
                    <div class=\"header\">
                        " . $author_name . "
                    </div>
                    <div class=\"image content\">
                        <div class=\"ui massive image\">
                            <img src=\"https://cdn.waterstones.com/bookjackets/large/9780/0074/9780007448036.jpg\">
                        </div>
                        <div class=\"description\">   
                            <div class=\"ui header\">Summary</div>                            
                            <p>" . $result_author['AUTHOR_SUMMARY'][0] . "</p>
                            <div class=\"ui header\">Author's Books</div>                            
                            <p> %s </p>
                        </div>
                    </div>                                      
                </div>";


    $book = "
        <div class=\"item\">
            <i class=\"book icon\"></i>
            <div class=\"content\">
                <a class=\"header\">%s</a>
            </div>
        </div>
    ";

    $book_list = "<div class=\"ui middle aligned divided list\">";
    for ($i = 0; $i < $n_row_book; $i++) {
        $book_list .= sprintf($book, $result_book['BOOKNAME'][$i]);
    }
    $book_list .= "</div>";

    echo sprintf($author, $book_list);

}