<?php

$form = "
<style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>

<iframe id='iframe-form' name=\"hiddenFrame\" class=\"hide\"></iframe>
<form id='book-form' action='formControllers/bookController.php' method='post' class=\"ui form\" enctype=\"multipart/form-data\" target=\"hiddenFrame\">
    <div class=\"field\">
        <input type=\"hidden\" name=\"mode\" value='%s'>
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Book ID</label>
            <input type=\"text\" name=\"book-id\" placeholder='Book ID' value='%s' readonly>
        </div>
        <div class=\"field\">
            <label>Book Name</label>
            <input type=\"text\" name=\"book-name\" placeholder=\"Book Name\" value='%s'>
        </div>         
    </div>
    <div class=\"field\">
            <label>Book Summary</label>
            <textarea rows=\"5\" name='book-summary' placeholder='Book Summary'>%s</textarea>
        </div>  
    <div class=\"three fields\">
        <div class=\"field\">
            <label>Author</label>
            <div class=\"ui selection dropdown\">
                <input type=\"hidden\" name=\"author\">
                    <i class=\"dropdown icon\"></i>
                    <div class=\"default text\">Select Author</div>
                    <div class=\"menu\">
                    %s
                    </div>
                </div>
            </div>
        <div class=\"field\">
            <label>Categories</label>
            <select name='categories[]' multiple=\"\" class=\"ui dropdown\">
                <option value=\"\">Select Categories</option>
                %s
            </select>
        </div>
        <div class='field'>
            <label>Cover Image</label>
            %s
            <label for=\"file\" class=\"ui icon button\" style='display: inline-block'>
                <i class=\"file icon\"></i> Upload
            </label>                
            <input type=\"file\" id=\"file\" name='file' style=\"display:none\">           
        </div> 
    </div>
</form>

<script>$('.field .dropdown').dropdown();</script>
";

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $modes = array("Add", "Edit", "Delete");
    $colors = array("blue", "orange", "red");
    $header = $modes[$_POST['mode']] . " Book";

    $button = "
<div style=\"text-align: center\">
    <input type=\"submit\" id=\"book-form-button\" class=\"ui " . $colors[$_POST['mode']] . " button\" value='" . $modes[$_POST['mode']] . "'/>
</div>";

    include "../DB.php";
    $db = new DB();

    $authors = "";
    $author = "<div class=\"item\" data-value=\"%s\">%s</div>";

    list($n_row, $result) = $db->selectAll('AUTHOR');
    for ($i = 0; $i < $n_row; $i++) {
        $authors .= sprintf($author, $result['AUTHORID'][$i], $result['AUTHOR_NAME'][$i]);
    }

    $category = "<option value=\"%s\">%s</option>";
    list($n_row, $result) = $db->selectAll('CATEGORYTBL');
    $categories = "";
    for ($i = 0; $i < $n_row; $i++) {
        $categories .= sprintf($category, $result['CATEGORYID'][$i], $result['CATEGORY_NAME'][$i]);
    }

    if ($_POST['id'] != "-1") {


        $result = $db->selectById('BOOK', 'BOOKID', $_POST['id'])[1];
        $content = sprintf($form,
            $_POST['mode'],
            $_POST['id'],
            $result['BOOKNAME'][0],
            $result['BOOK_SUMMARY'][0],
            $authors,
            $categories,
            "<img class=\"ui tiny image\" src='images/" . $result['COVER_IMAGE'][0] . "'/>"

        );
    } else {

        $content = sprintf($form,
            $_POST['mode'], "", "", "", $authors, $categories, "");
    }

    echo json_encode(['header' => $header, 'content' => $content, 'button' => $button]);
}

?>

