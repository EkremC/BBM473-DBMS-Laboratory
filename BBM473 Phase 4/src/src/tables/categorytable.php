<div class="ui icon buttons">
    <button class="ui blue button" onclick="crud(0, 'category')">
        <i class="plus icon"></i>
        Add
    </button>
    <button class="ui orange button" onclick="crud(1, 'category')">
        <i class="edit icon"></i>
        Edit
    </button>
    <button class="ui red button" onclick="crud(2, 'category')">
        <i class="minus icon"></i>
        Delete
    </button>
</div>

<table class="ui selectable celled table">
    <thead>
    <tr>
        <th>Category ID</th>
        <th>Category Name</th>
        <th>Insert Admin</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $row = "<tr id='category-%s'>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>";

    include "../DB.php";
    $db = new DB();
    list($n_rows, $result) = $db->selectAll('CATEGORY_ADMINVIEW');

    for ($i = 0; $i < $n_rows; $i++) {
        echo sprintf($row, $result['CATEGORYID'][$i], $result['CATEGORYID'][$i], $result['CATEGORY_NAME'][$i], $result['INSERTUSER'][$i]);
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

