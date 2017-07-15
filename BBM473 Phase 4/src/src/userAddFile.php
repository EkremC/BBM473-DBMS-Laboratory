<?php

$post = json_decode(file_get_contents('php://input'), true);
if (!empty($post)) {
    include "DB.php";
    $db = new DB();
    session_start();
    $user_id = $_SESSION['user'];
    $data = $post['data'];
    $type = $post['type'];
    $file_view = $type == 'ebook' ? 'EBOOK_VIEW' : 'AUDIOBOOK_VIEW';


    $response = array();
    foreach ($data as $item) {
        $file_id = $item['file'];
        $shelf_id = $item['shelf'];
        if ($shelf_id != -1) { // if not library
            $params = array($user_id, $shelf_id, $file_id);
            $status = $db->executeProcedure($params, 'SHELFFILE_INSERT');
            list($n_rows_shelf, $result_shelf) = $db->selectById('SHELF', 'SHELFID', $shelf_id);
            list($n_rows_file, $result_file) = $db->selectById($file_view, 'FILEID', $file_id);
            if ($status == true) {
                $text = '\'' . $result_file['BOOKNAME'][0] . '\' is added to your shelf \''
                    . $result_shelf['SHELFNAME'][0] . '\'.';
                array_push($response, ['res' => true, 'text' => $text]);
            } else {
                $text = '\'' . $result_file['BOOKNAME'][0] . '\' has already been added to shelf \''
                    . $result_shelf['SHELFNAME'][0] . '\'.';
                array_push($response, ['res' => false, 'text' => $text]);
            }
        } else {
            $params = array($user_id, $file_id);
            $status = $db->executeProcedure($params, 'LIBRARY_INSERT');
            list($n_rows_file, $result_file) = $db->selectById($file_view, 'FILEID', $file_id);
            if ($status == true) {
                $text = '\'' . $result_file['BOOKNAME'][0] . '\' is added to your library.';
                array_push($response, ['res' => true, 'text' => $text]);
            } else {
                $text = '\'' . $result_file['BOOKNAME'][0] . '\' is already in your library.';
                array_push($response, ['res' => false, 'text' => $text]);
            }
        }
    }
    header('Content-type: application/json');
    $response = json_encode($response);
    echo $response;
}