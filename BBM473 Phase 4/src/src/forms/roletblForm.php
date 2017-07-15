<?php

$form = "
<style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>

<iframe name=\"hiddenFrame\" class=\"hide\"></iframe>
<form id='roletbl-form' action='formControllers/roletblController.php' method='post' class=\"ui form\" enctype=\"multipart/form-data\" target=\"hiddenFrame\">
    <div class=\"field\">
        <input type=\"hidden\" name=\"mode\" value='%s'>
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Role ID</label>
            <input type=\"text\" name=\"roletbl-id\" placeholder='Role ID' value='%s' readonly>
        </div>
        <div class=\"field\">
            <label>Role Name</label>
            <input type=\"text\" name=\"rolename\" placeholder=\"Role Name\" value='%s'>
        </div>     
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Role Description</label>
            <input type=\"text\" name=\"description\" placeholder=\"Description\" value='%s'>
        </div>
        <div class=\"field\">
            <label>Permissions</label>
            <select name='permissions[]' multiple=\"\" class=\"ui dropdown\">
                <option value=\"\">Select Permissions</option>
                %s
            </select>
        </div>
    </div>
</form>

<script>$('.field .dropdown').dropdown();</script>
";

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $modes = array("Add", "Edit", "Delete");
    $colors = array("blue", "orange", "red");
    $header = $modes[$_POST['mode']] . " Role";

    $button = "
<div style=\"text-align: center\">
    <input type=\"submit\" id=\"roletbl-form-button\" class=\"ui " . $colors[$_POST['mode']] . " button\" value='" . $modes[$_POST['mode']] . "'/>
</div>";

    include "../DB.php";
    $db = new DB();

    $option = "<option value=\"%s\">%s</option>";
    list($n_row, $permissions) = $db->selectAll('PERMISSIONTBL');
    $options = "";
    for ($i = 0; $i < $n_row; $i++) {
        $options .= sprintf($option, $permissions['PERMISSIONID'][$i], $permissions['PERMISSION_NAME'][$i]);
    }

    if ($_POST['id'] != "-1") {

        $result = $db->selectById('ROLETBL', 'ROLEID', $_POST['id'])[1];


        $content = sprintf($form,
            $_POST['mode'],
            $_POST['id'],
            $result['ROLENAME'][0],
            $result['DESCRIPTION'][0],
            $options
        );
    } else {
        $content = sprintf($form,
            $_POST['mode'], "", "", "", $options);
    }

    echo json_encode(['header' => $header, 'content' => $content, 'button' => $button]);
}

?>

