<?php
if (isset($_POST['shelf']) && !empty($_POST['shelf'])) {
    include 'DB.php';
    $db = new DB();
    $shelf_id = $_POST['shelf'];
    list($n_row_shelf, $result) = $db->selectById('USER_SHELF_VIEW', 'SHELFID', $shelf_id);

    $item_format = "<div class=\"ui cards\" id=\"user-shelf-info\" style=\"height: 339px; margin-top: 15px; margin-bottom: 15px;\">
	<div style='padding-right: 10px; padding-left: 10px;'>
	<div class='ui fluid card' style='width: 160px; height: 338px;'>

		<a class='image' href='#' onclick='%s'>

			<img src='%s' class='ui image hoverZoomLink' style='height: auto; width: 160px;'>

		</a>
		<div class='content'>
			<a class='header' href='#' style='font-size:16px;'onclick='%s'>%s</a>
			<div class='meta'>
				<a>Published by %s</a>
			</div>
		</div>
	</div>
</div>
</div>";

    for ($i = 0; $i < $n_row_shelf; $i++) {
        $row = array();

        $on_click = 'showBookContent(' . $result['BOOKNAME'][$i] . ', 0); return false;';
        $item = sprintf($item_format, $on_click, 'http://ecx.images-amazon.com/images/I/61gQLALjWsL._SX326_BO1,204,203,200_.jpg',
            $on_click, $result['BOOKNAME'][$i], $result['PUBLISHER_NAME'][$i]);
        echo $item;
    }

}
?>