<?php

$form = "
<style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>

<iframe name=\"hiddenFrame\" class=\"hide\"></iframe>
<form id='permissiontbl-form' action='formControllers/permissiontblController.php' method='post' class=\"ui form\" enctype=\"multipart/form-data\" target=\"hiddenFrame\">
    <div class=\"field\">
        <input type=\"hidden\" name=\"mode\" value='%s'>
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Permission ID</label>
            <input type=\"text\" name=\"permissionid\" placeholder='Permission ID' value='%s' readonly>
        </div>
        <div class=\"field\">
            <label>Permission Name</label>
            <input type=\"text\" name=\"permissionname\" placeholder=\"Permission Name\" value='%s'>
        </div>      
        <div class=\"field\">
            <label>Description</label>
            <input type=\"text\" name=\"description\" placeholder=\"Description\" value='%s'>
        </div>
    </div>
    
</form>
";

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $modes = array("Add", "Edit", "Delete");
    $colors = array("blue", "orange", "red");
    $header = $modes[$_POST['mode']] . " Permission";

    $button = "
<div style=\"text-align: center\">
    <input type=\"submit\" id=\"permissiontbl-form-button\" class=\"ui " . $colors[$_POST['mode']] . " button\" value='" . $modes[$_POST['mode']] . "'/>
</div>";

    if ($_POST['id'] != "-1") {
        include "../DB.php";
        $db = new DB();
        $result = $db->selectById('PERMISSIONTBL', 'PERMISSIONID', $_POST['id'])[1];
        $content = sprintf($form,
            $_POST['mode'],
            $_POST['id'],
            $result['PERMISSION_NAME'][0],
            $result['DESCRIPTION'][0]
        );
    } else {
        $content = sprintf($form,
            $_POST['mode'], "", "", "", "");
    }

    echo json_encode(['header' => $header, 'content' => $content, 'button' => $button]);
}

?>

