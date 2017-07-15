<?php


if (isset($_POST['fileid']) && !empty($_POST['fileid'])) {

    session_start();
    $userid = $_SESSION['user'];
    $mode = $_POST['shelfid'] == -1 ? 0 : 1;
    include "DB.php";
    $db = new DB();
    if ($mode == 1) {
        $params = array($userid, $_POST['shelfid'], $_POST['fileid']);
        $status = $db->executeProcedure($params, 'SHELFFILE_DELETE');
        echo $status == true ? "1-Successfuly removed from your shelf" : "0-Failed to remove book from your shelf";
    } else {
        $params = array($userid, $_POST['fileid']);
        $status = $db->executeProcedure($params, 'LIBRARY_SINGLE_DELETE');
        echo $status == true ? "1-Successfuly removed from your library and your shelves" : "0-Failed to remove book from your library";
    }


}