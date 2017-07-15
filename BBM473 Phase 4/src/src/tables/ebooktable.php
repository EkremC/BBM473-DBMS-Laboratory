<div class="ui icon buttons">
    <button class="ui blue button" onclick="crud(0, 'ebook')">
        <i class="plus icon"></i>
        Add
    </button>
    <button class="ui orange button" onclick="crud(1, 'ebook')">
        <i class="edit icon"></i>
        Edit
    </button>
    <button class="ui red button" onclick="crud(2, 'ebook')">
        <i class="minus icon"></i>
        Delete
    </button>
</div>

<table class="ui selectable celled table">
    <thead>
    <tr>
        <th>Ebook Name</th>
        <th>Publisher</th>
        <th>Page Number</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $row = "<tr id='ebook-%s'>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>";

    include "../DB.php";
    $db = new DB();
    list($n_rows, $result) = $db->selectAll('EBOOK_VIEW');

    for ($i = 0; $i < $n_rows; $i++) {
        echo sprintf($row, $result['FILEID'][$i], $result['BOOKNAME'][$i], $result['PUBLISHER'][$i], $result['PAGE_NUMBER'][$i], $result['PUBLISH_DATE'][$i]);
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

