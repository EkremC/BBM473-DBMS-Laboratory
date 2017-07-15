<?php

if(isset($_POST['mode'])) {

    include "../DB.php";
    $db = new DB();
    session_start();
    $user_id = $_SESSION['user'];

    if ($_POST['mode'] == 0) {
        $ispublic = $_POST['shelf-public'] == "on" ? 1 : 0;
        $params = array($_POST['shelf-name'], $user_id, $ispublic);
        $status = $db->executeProcedure($params, 'SHELF_INSERT');
    } else if ($_POST['mode'] == 1) {
        $ispublic = (isset($_POST['shelf-public']) and $_POST['shelf-public'] == "on") ? 1 : 0;
        $params = array($_POST['shelf-id'], $_POST['shelf-name'], $user_id, $ispublic);
        $status = $db->executeProcedure($params, 'SHELF_UPDATE');
    } else if ($_POST['mode'] == 2) {
        $params = array($user_id, $_POST['shelf-id']);
        $status = $db->executeProcedure($params, 'SHELF_DELETE');
    }
    $response = json_encode(['status' => $status, 'mode' => $_POST['mode']]);
    echo $response;

}