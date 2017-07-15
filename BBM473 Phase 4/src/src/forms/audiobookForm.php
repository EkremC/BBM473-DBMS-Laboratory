<?php

$form = "
<style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>

<iframe name=\"hiddenFrame\" class=\"hide\"></iframe>
<form id='audiobook-form' action='formControllers/audiobookController.php' method='post' class=\"ui form\" enctype=\"multipart/form-data\" target=\"hiddenFrame\">

    <div class=\"field\">
        <input type=\"hidden\" name=\"mode\" value='%s'>
    </div>
    <div class=\"field\">
            <input type=\"hidden\" name=\"file-id\" value='%s' readonly> 
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>AudioBook ID</label>
            <input type=\"text\" name=\"book-id\" placeholder='Book ID' value='%s'>
        </div>
        <div class=\"field\">
            <label>Publisher ID</label>
            <input type=\"text\" name=\"audiobook-publisher-id\" placeholder='Publisher ID' value='%s'>
        </div>         
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>AudioBook File</label>
            <input type=\"text\" name=\"audiobook-file\" placeholder='AudioBook File' value='%s'>
        </div>
        <div class=\"field\">
            <label>AudioBook Size</label>
            <input type=\"text\" name=\"audiobook-size\" placeholder='AudioBook Size' value='%s'>
        </div>         
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>AudioBook Language</label>
            <input type=\"text\" name=\"audiobook-language\" placeholder='AudioBook Language' value='%s'>
        </div>
        <div class=\"field\">
            <label>AudioBook Total Duration</label>
            <input type=\"text\" name=\"audiobook-total-duration\" placeholder='AudioBook Total Duration' value='%s'>
        </div>         
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Publish Date</label>
            <input type=\"text\" name=\"audiobook-publish-date\" placeholder='Publish Date' value='%s'>
        </div>  
        <div class=\"field\">
            <label>Page Number</label>
            <input type=\"text\" name=\"audiobook-page-number\" placeholder='Page Number' value='%s'>
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
    <input type=\"submit\" id=\"audiobook-form-button\" class=\"ui " . $colors[$_POST['mode']] . " button\" value='" . $modes[$_POST['mode']] . "'/>
</div>";

    if ($_POST['id'] != "-1") {
        include "../DB.php";
        $db = new DB();
        $result = $db->selectById('AUDIOBOOK_VIEW', 'FILEID', $_POST['id'])[1];
        $content = sprintf($form,
            $_POST['mode'],
            $_POST['id'],
            $result['BOOKID'][0],
            $result['PUBLISHERID'][0],
            $result['AUDIO_FILE'][0],
            $result['FILE_SIZE'][0],
            $result['FILE_LANGUAGE'][0],
            $result['TOTAL_DURATION'][0],
            $result['PUBLISH_DATE'][0], 
            $result['PAGE_NUMBER'][0]
        );
    } else {
        $content = sprintf($form,
            $_POST['mode'], "", "", "", "", "", "", "","", "");
    }

    echo json_encode(['header' => $header, 'content' => $content, 'button' => $button]);
}

?>

