<div class="ui icon buttons">
    <button class="ui blue button" onclick="crud(0, 'roletbl')">
        <i class="plus icon"></i>
        Add
    </button>
    <button class="ui orange button" onclick="crud(1, 'roletbl')">
        <i class="edit icon"></i>
        Edit
    </button>
    <button class="ui red button" onclick="crud(2, 'roletbl')">
        <i class="minus icon"></i>
        Delete
    </button>
</div>

<table class="ui selectable celled table">
    <thead>
    <tr>
        <th>Role ID</th>
        <th>Role Name</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $row = "<tr id='roletbl-%s'>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>";

    include "../DB.php";
    $db = new DB();
    list($n_rows, $result) = $db->selectAll('ROLETBL');

    for ($i = 0; $i < $n_rows; $i++) {
        echo sprintf($row, $result['ROLEID'][$i], $result['ROLEID'][$i], $result['ROLENAME'][$i], $result['DESCRIPTION'][$i]);
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

