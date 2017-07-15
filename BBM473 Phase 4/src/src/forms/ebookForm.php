<?php

$form = "
<style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>

<iframe name=\"hiddenFrame\" class=\"hide\"></iframe>
<form id='ebook-form' action='formControllers/ebookController.php' method='post' class=\"ui form\" enctype=\"multipart/form-data\" target=\"hiddenFrame\">

    <div class=\"field\">
        <input type=\"hidden\" name=\"mode\" value='%s'>
    </div>
    <div class=\"field\">
            <input type=\"hidden\" name=\"file-id\" value='%s' readonly> 
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Book ID</label>
            <input type=\"text\" name=\"book-id\" placeholder='Book ID' value='%s'>
        </div>
        <div class=\"field\">
            <label>Publisher ID</label>
            <input type=\"text\" name=\"ebook-publisher-id\" placeholder='Publisher ID' value='%s'>
        </div>         
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Ebook File</label>
            <input type=\"text\" name=\"ebook-file\" placeholder='Ebook File' value='%s'>
        </div>
        <div class=\"field\">
            <label>Ebook Size</label>
            <input type=\"text\" name=\"ebook-size\" placeholder='Ebook Size' value='%s'>
        </div>         
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Ebook Language</label>
            <input type=\"text\" name=\"ebook-language\" placeholder='Ebook Language' value='%s'>
        </div>
        <div class=\"field\">
            <label>Ebook Page Number</label>
            <input type=\"text\" name=\"ebook-page-number\" placeholder='Ebook Page Number' value='%s'>
        </div>         
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Publish Date</label>
            <input type=\"text\" name=\"ebook-publish-date\" placeholder='Publish Date' value='%s'>
        </div>    
    </div>
    
</form>
";

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $modes = array("Add", "Edit", "Delete");
    $colors = array("blue", "orange", "red");
    $header = $modes[$_POST['mode']] . " ebook";

    $button = "
<div style=\"text-align: center\">
    <input type=\"submit\" id=\"ebook-form-button\" class=\"ui " . $colors[$_POST['mode']] . " button\" value='" . $modes[$_POST['mode']] . "'/>
</div>";

    if ($_POST['id'] != "-1") {
        include "../DB.php";
        $db = new DB();
        $result = $db->selectById('EBOOK_VIEW', 'FILEID', $_POST['id'])[1];
        $content = sprintf($form,
            $_POST['mode'],
            $_POST['id'],
            $result['BOOKID'][0],
            $result['PUBLISHERID'][0],
            $result['EBOOK_FILE'][0],
            $result['FILE_SIZE'][0],
            $result['FILE_LANGUAGE'][0],
            $result['PAGE_NUMBER'][0],
            $result['PUBLISH_DATE'][0]
        );
    } else {
        $content = sprintf($form,
            $_POST['mode'], "", "", "", "", "", "", "","");
    }

    echo json_encode(['header' => $header, 'content' => $content, 'button' => $button]);
}

?>

