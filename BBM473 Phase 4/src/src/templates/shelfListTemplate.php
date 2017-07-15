<div class="ui icon buttons">
    <button class="ui blue button" onclick="shelfCRUD(0)">
        <i class="plus icon"></i>
        Add
    </button>
    <button class="ui orange button" onclick="shelfCRUD(1)">
        <i class="edit icon"></i>
        Edit
    </button>
    <button class="ui red button" onclick="shelfCRUD(2)">
        <i class="minus icon"></i>
        Delete
    </button>
</div>

<table class="ui selectable celled table">
    <thead>
    <tr>
        <th>Shelf Name</th>
        <th>Is Public</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $row = "<tr id='shelf-%s'><td>%s</td><td>%s</td></tr>";

    include "../DB.php";
    $db = new DB();
    session_start();
    $userid = $_SESSION['user'];
    list($n_rows, $result) = $db->selectById('SHELF', 'USERID', $userid);

    for ($i = 0; $i < $n_rows; $i++) {
        $ispublic = $result['ISPUBLIC'][$i] == 1 ? "checkmark" : "remove";
        echo sprintf($row, $result['SHELFID'][$i], $result['SHELFNAME'][$i], "<i class=\"" . $ispublic . " icon\"></i>");
    }

    ?>
    </tbody>
</table>

<div class="ui modal">
    <i class="close icon"></i>
    <div class="header">

    </div>
    <div class="ui text container" style="padding: 50px; size: 200px;">

    </div>
    <div class="actions">

    </div>
</div>

<style>
    .buttons .button {
        opacity: 0.9;
        width: 90px;
    }

    tr {
        cursor: default;
    }

    .highlight {
        background: #dfe0e1;
    }

</style>

<?php

