<?php

$form = "
<style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>

<iframe name=\"hiddenFrame\" class=\"hide\"></iframe>
<form id='author-form' action='formControllers/authorController.php' method='post' class=\"ui form\" enctype=\"multipart/form-data\" target=\"hiddenFrame\">
    <div class=\"field\">
        <input type=\"hidden\" name=\"mode\" value='%s'>
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Author ID</label>
            <input type=\"text\" name=\"author-id\" placeholder='Author ID' value='%s' readonly>
        </div>
        <div class=\"field\">
            <label>Author Name</label>
            <input type=\"text\" name=\"author-name\" placeholder=\"Author Name\" value='%s'>
        </div>         
    </div>
    <div class=\"field\">
            <label>Author Summary</label>
            <textarea rows=\"5\" name='author-summary' placeholder='Author Summary'>%s</textarea>
        </div>  
    <div class=\"three fields\">
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
";

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $modes = array("Add", "Edit", "Delete");
    $colors = array("blue", "orange", "red");
    $header = $modes[$_POST['mode']] . " Author";

    $button = "
<div style=\"text-align: center\">
    <input type=\"submit\" id=\"author-form-button\" class=\"ui " . $colors[$_POST['mode']] . " button\" value='" . $modes[$_POST['mode']] . "'/>
</div>";

    if ($_POST['id'] != "-1") {
        include "../DB.php";
        $db = new DB();
        $result = $db->selectById('AUTHOR', 'AUTHORID', $_POST['id'])[1];
        $content = sprintf($form,
            $_POST['mode'],
            $_POST['id'],
            $result['AUTHOR_NAME'][0],
            $result['AUTHOR_SUMMARY'][0],
            "<img class=\"ui tiny image\" src='images/" . $result['IMAGE'][0] . "'/>"

        );
    } else {
        $content = sprintf($form,
            $_POST['mode'], "", "", "", "");
    }

    echo json_encode(['header' => $header, 'content' => $content, 'button' => $button]);
}

?>

