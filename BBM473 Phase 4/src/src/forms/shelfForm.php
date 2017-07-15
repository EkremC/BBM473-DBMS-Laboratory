<?php

$form = "
<form id='shelf-form' class=\"ui form\">
    <div class=\"field\">
        <input type=\"hidden\" name=\"mode\" placeholder=\"Shelf Name\" value='%s'>
    </div>
    <div class=\"field\">
        <input type=\"hidden\" name=\"shelf-id\" placeholder=\"Shelf Name\" value='%s'>
    </div>
    <div class=\"field\">
        <label>Shelf Name</label>
        <input type=\"text\" name=\"shelf-name\" placeholder=\"Shelf Name\" value='%s'>
    </div>
    <div class=\"field\">
        <label>Is Public</label>
        <div class=\"ui toggle checkbox\">
          <input type=\"checkbox\" name='shelf-public' %s>
          <label></label>
        </div>
    </div>    
</form>
";


if (isset($_POST['shelfid']) && !empty($_POST['shelfid'])) {
    $modes = array("Add", "Edit", "Delete");
    $colors = array("blue", "orange", "red");
    $header = $modes[$_POST['mode']] . " Shelf";

    $button = "
<div style=\"text-align: center\">
    <input type=\"submit\" id=\"shelf-form-button\" class=\"ui " . $colors[$_POST['mode']] . " button\" value='" . $modes[$_POST['mode']] . "'/>
</div>";

    if ($_POST['shelfid'] != "-1") {
        include "../DB.php";
        $db = new DB();
        $result = $db->selectById('SHELF', 'SHELFID', $_POST['shelfid'])[1];
        $checked = $result['ISPUBLIC'][0] == 1 ? "checked" : "";
        $content = sprintf($form, $_POST['mode'], $_POST['shelfid'], $result['SHELFNAME'][0], $checked);
    } else {
        $content = sprintf($form, $_POST['mode'], -1, "", "");
    }

    echo json_encode(['header' => $header, 'content' => $content, 'button' => $button]);
}

?>

