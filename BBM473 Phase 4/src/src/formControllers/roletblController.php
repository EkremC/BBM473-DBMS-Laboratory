<?php

if (isset($_POST['mode'])) {

    include "../DB.php";
    $db = new DB();
    session_start();
    $user_id = $_SESSION['user'];


    if ($_POST['mode'] != 2) {


        if ($_POST['mode'] == 0) {
            $params = array($_POST['rolename'], $_POST['description']);
            $status = $db->executeProcedure($params, 'ROLE_INSERT');
            if ($status == true) {
                $lastid = $db->executeQuery(" select role_seq.currval from dual ")[1]['CURRVAL'][0];
                for ($i = 0; $i < count($_POST['permissions']); $i++) {
                    $params = array($lastid, $_POST['permissions'][$i]);
                    $status = $db->executeProcedure($params, 'ROLEPERMISSION_INSERT');
                }
            }
        } else if ($_POST['mode'] == 1) {
            $params = array($_POST['roleid'], $_POST['rolename'], $_POST['description']);
            $status = $db->executeProcedure($params, 'ROLE_UPDATE');
            if ($status == true) {
                for ($i = 0; $i < count($_POST['permissions']); $i++) {
                    $params = array($_POST['roleid'], $_POST['permissions'][$i]);
                    $status = $db->executeProcedure($params, 'ROLEPERMISSION_INSERT');
                }
            }
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

