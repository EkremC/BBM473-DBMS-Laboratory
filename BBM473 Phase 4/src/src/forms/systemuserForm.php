<?php

$form = "
<style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>

<iframe id='iframe-form' name=\"hiddenFrame\" class=\"hide\"></iframe>
<form id='systemuser-form' action='formControllers/systemuserController.php' method='post' class=\"ui form\" enctype=\"multipart/form-data\" target=\"hiddenFrame\">
    <div class=\"field\">
        <input type=\"hidden\" name=\"mode\" value='%s'>
    </div>
    <div class=\"three fields\">
        <div class=\"field\">
            <label>User ID</label>
            <input type=\"text\" name=\"systemuser-id\" placeholder='Book ID' value='%s' readonly>
        </div>
        <div class=\"field\">
            <label>Username</label>
            <input type=\"text\" name=\"username\" placeholder=\"username\" value='%s'>
        </div>    
        <div class=\"field\">
            <label>Password</label>
            <input type=\"password\" name=\"password\" placeholder=\"password\" value='%s'>
        </div>    
    </div>
    <div class=\"three fields\">
        <div class=\"field\">
            <label>First Name</label>
            <input type=\"text\" name=\"firstname\" placeholder='First name' value='%s'>
        </div>
        <div class=\"field\">
            <label>Last Name</label>
            <input type=\"text\" name=\"surname\" placeholder=\"Last Name\" value='%s'>
        </div>    
        <div class=\"field\">
            <label>Region</label>
            <input type=\"text\" name=\"region\" placeholder=\"Region\" value='%s'>
        </div>    
    </div>
    <div class=\"two fields\">
        <div class=\"field\">
            <label>Role</label>
            <input type=\"text\" name=\"role\" placeholder='Role' value='%s'>
        </div>
        <div class=\"field\">
            <label>Is Active</label>
            <input type=\"text\" name=\"isactive\" placeholder=\"Is Active\" value='%s'>
        </div>     
    </div>
    <div class=\"three fields\">
        <div class=\"field\">
            <label>Country</label>
            <input type=\"text\" name=\"country\" placeholder=\"Country\" value='%s'>
        </div>
        <div class=\"field\">
            <label>City</label>
            <input type=\"text\" name=\"city\" placeholder=\"City\" value='%s'>
        </div>    
        <div class=\"field\">
            <label>Phone</label>
            <input type=\"text\" name=\"phone\" placeholder=\"Phone\" value='%s'>
        </div>    
    </div>
</form>
";

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $modes = array("Add", "Edit", "Delete");
    $colors = array("blue", "orange", "red");
    $header = $modes[$_POST['mode']] . " System User";

    $button = "
<div style=\"text-align: center\">
    <input type=\"submit\" id=\"systemuser-form-button\" class=\"ui " . $colors[$_POST['mode']] . " button\" value='" . $modes[$_POST['mode']] . "'/>
</div>";

    if ($_POST['id'] != "-1") {
        include "../DB.php";
        $db = new DB();
        $result = $db->selectById('SYSTEMUSER_VIEW', 'USERID', $_POST['id'])[1];
        $content = sprintf($form,
            $_POST['mode'],
            $_POST['id'],
            $result['USERID'][0],
            $result['USERNAME'][0],
            "",
            $result['FIRSTNAME'][0],
            $result['SURNAME'][0],
            $result['REGION'][0],
            $result['ISACTIVE'][0],
            $result['COUNTRY'][0],
            $result['CITY'][0],
            $result['PHONE'][0]
        );
    } else {
        $content = sprintf($form,
            $_POST['mode'], "", "", "", "", "", "", "", "", "", "", "");
    }

    echo json_encode(['header' => $header, 'content' => $content, 'button' => $button]);
}

?>

