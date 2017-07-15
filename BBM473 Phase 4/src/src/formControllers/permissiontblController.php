<?php

if (isset($_POST['mode'])) {

    include "../DB.php";
    $db = new DB();
    session_start();
    $user_id = $_SESSION['user'];


    if ($_POST['mode'] != 2) {


        if ($_POST['mode'] == 0) {
            $params = array($_POST['permissionname'], $_POST['description']);
            $status = $db->executeProcedure($params, 'PERMISSION_INSERT');
        } else if ($_POST['mode'] == 1) {
            $params = array($_POST['permissionid'], $_POST['permissionname'], $_POST['description']);
            $status = $db->executeProcedure($params, 'PERMISSION_UPDATE');
        }



    } else if ($_POST['mode'] == 2) {
        $params = array($_POST['permissionid']);
        $status = $db->executeProcedure($params, 'PERMISSION_DELETE');
    }
    $response = json_encode(['status' => $status, 'mode' => $_POST['mode']]);
    echo "<script type=\"text/javascript\">
                parent.formControllerOnFinish('" . $response . "', 'permissiontbl');
                parent.closeIFrame();
         </script>";

}

