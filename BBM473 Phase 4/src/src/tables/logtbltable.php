

<table class="ui selectable celled table">
    <thead>
    <tr>
        <th>Username</th>
        <th>Tablename</th>
        <th>Object ID</th>
        <th>Operation</th>
        <th>Operation Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $row = "<tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>";

    include "../DB.php";
    $db = new DB();
    list($n_rows, $result) = $db->executeQuery(' SELECT *FROM LOGTBL ORDER BY LOG_DATE DESC FETCH FIRST 10 ROWS ONLY ');
    list($n_rows_user, $result_user) = $db->selectAll('USERTBL');


    for ($i = 0; $i < $n_rows; $i++) {
        $username = "";
        for ($j = 0; $j < $n_rows_user; $j++) {
            if ($result_user['USERID'][$j] == $result['USERID'][$i])
                $username = $result_user['USERNAME'][$j];
        }
        if ($result['OPERATION_TYPE'][$i] == 'I') {
            $operation = 'Insert';
        } else if ($result['OPERATION_TYPE'][$i] == 'U') {
            $operation = 'Update';
        } else {
            $operation = 'Delete';
        }
        echo sprintf($row, $username, $result['TABLENAME'][$i], $result['OBJECTID'][$i], $operation, $result['LOG_DATE'][$i]);
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

