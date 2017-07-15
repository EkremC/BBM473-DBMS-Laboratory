<?php

if (isset($_POST['mode'])) {

    include "../DB.php";
    $db = new DB();
    session_start();
    $user_id = $_SESSION['user'];


    if ($_POST['mode'] != 2) {


        if ($_POST['mode'] == 0) {
            $params = array($_POST['ebook-size'], $_POST['ebook-language'], $_POST['ebook-page-number'], $_POST['book-id'], $_POST['ebook-publisher-id'], $user_id, $user_id, date('d-M-y'), date('d-M-y'), $_POST['ebook-publish-date'], $_POST['ebook-file']);
            $status = $db->executeProcedure($params, 'EBOOK_INSERT');
        } else if ($_POST['mode'] == 1) {
            $params = array($_POST['file-id'], $_POST['ebook-size'], $_POST['ebook-language'], $_POST['ebook-page-number'], $_POST['book-id'], $_POST['ebook-publisher-id'], $user_id, $user_id, date('d-M-y'), date('d-M-y'), $_POST['ebook-publish-date'], $_POST['ebook-file']);
            $status = $db->executeProcedure($params, 'EBOOK_UPDATE');
        }


    } else if ($_POST['mode'] == 2) {
        $params = array($_POST['file-id'], $user_id);
        $status = $db->executeProcedure($params, 'EBOOK_DELETE');
    }
    $response = json_encode(['status' => $status, 'mode' => $_POST['mode']]);
    echo "<script type=\"text/javascript\">
                parent.formControllerOnFinish('" . $response . "', 'ebook');
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