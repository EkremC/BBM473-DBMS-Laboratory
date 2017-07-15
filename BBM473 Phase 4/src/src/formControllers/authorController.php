<?php

if (isset($_POST['mode'])) {

    include "../DB.php";
    $db = new DB();
    session_start();
    $user_id = $_SESSION['user'];


    if ($_POST['mode'] != 2) {

        if (isset($_FILES['file'])) {
            $img_path = generateRandomString() . "." . explode('/', $_FILES['file']['type'])[1];
            $sourcePath = $_FILES['file']['tmp_name'];
            $targetPath = dirname(getcwd()) . "/images/" . $img_path;
        } else {
            $img_path = $db->selectById('AUTHOR', 'AUTHORID', $_POST['author-id'])[1]['IMAGE'][0];
        }

        if ($_POST['mode'] == 0) {
            $params = array($_POST['author-name'], $_POST['author-summary'], $img_path, $user_id, $user_id, date('d-M-y'), date('d-M-y'));
            $status = $db->executeProcedure($params, 'AUTHOR_INSERT');
        } else if ($_POST['mode'] == 1) {
            $params = array($_POST['author-id'], $_POST['author-name'], $_POST['author-summary'], $img_path, $user_id, $user_id, date('d-M-y'), date('d-M-y'));
            $status = $db->executeProcedure($params, 'AUTHOR_UPDATE');
        }

        if ($status == true && isset($_FILES['file'])) {
            move_uploaded_file($sourcePath, $targetPath);
        }

    } else if ($_POST['mode'] == 2) {
        $params = array($_POST['author-id'], $user_id);
        $status = $db->executeProcedure($params, 'AUTHOR_DELETE');
    }
    $response = json_encode(['status' => $status, 'mode' => $_POST['mode']]);
       echo "<script type=\"text/javascript\">
                parent.formControllerOnFinish('" . $response . "', 'author');
                parent.closeIFrame();
         </script>";

}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}