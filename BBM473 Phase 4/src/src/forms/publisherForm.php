<?php

$form = "
<style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>

<iframe name=\"hiddenFrame\" class=\"hide\"></iframe>
<form id='publisher-form' action='formControllers/publisherController.php' method='post' class=\"ui form\" enctype=\"multipart/form-data\" target=\"hiddenFrame\">
    <div class=\"field\">
        <input type=\"hidden\" name=\"mode\" value='%s'>
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Publisher ID</label>
            <input type=\"text\" name=\"publisher-id\" placeholder='Publisher ID' value='%s' readonly>
        </div>
        <div class=\"field\">
            <label>Publisher Name</label>
            <input type=\"text\" name=\"publisher-name\" placeholder=\"Publisher Name\" value='%s'>
        </div>         
    </div>
    <div class=\"field\">
            <label>Publisher Summary</label>
            <textarea rows=\"5\" name='publisher-summary' placeholder='Publisher Summary'>%s</textarea>
        </div>  
</form>
";

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $modes = array("Add", "Edit", "Delete");
    $colors = array("blue", "orange", "red");
    $header = $modes[$_POST['mode']] . " Publisher";

    $button = "
<div style=\"text-align: center\">
    <input type=\"submit\" id=\"publisher-form-button\" class=\"ui " . $colors[$_POST['mode']] . " button\" value='" . $modes[$_POST['mode']] . "'/>
</div>";

    if ($_POST['id'] != "-1") {
        include "../DB.php";
        $db = new DB();
        $result = $db->selectById('PUBLISHER', 'PUBLISHERID', $_POST['id'])[1];
        $content = sprintf($form,
            $_POST['mode'],
            $_POST['id'],
            $result['PUBLISHER_NAME'][0],
            $result['PUBLISHER_SUMMARY'][0]

        );
    } else {
        $content = sprintf($form,
            $_POST['mode'], "", "", "", "");
    }

    echo json_encode(['header' => $header, 'content' => $content, 'button' => $button]);
}

?>

