<?php include_once 'header.php';

$params = null;
$params['fld'] = 'ID';
$params['opp'] = '!=';
$params['val'] = '';
$teams = new teams();
$teams = $teams->FindAllByParams($params);

?>
<style>

    h1 {text-align: center;}

    td, tr {
        border: 2px solid #0c2340;
    }

    th {
        background-color: #00b2a9;
        color: #0c2340;
        cursor: pointer;
    }

    table {
        border: 3px solid #0c2340 !important;
    }

    th {
        border-bottom: 3px solid #0c2340 !important;
    }
</style>

<h1>Players</h1>

<table id='playerTable' class="table sortable">
    <thead>
        <tr>
            <th scope="col" style="width:14%">NickName</th>
            <th scope="col" style="width:9%">Throwing</th>
            <th scope="col" style="width:9%">Cutting</th>
            <th scope="col" style="width:9%">Speed</th>
            <th scope="col" style="width:10%">Conditioning</th>
            <th scope="col" style="width:9%">Experience</th>
            <th scope="col" style="width:14%">Buddy</th>
            <th scope="col" style="width:9%">Height</th>
            <th scope="col" style="width:9%">Gender</th>
            <th scope="col" style="width:9%">Absence</th>
            <th scope="col" style="width:8%">Playoffs</th>
        </tr>
    </thead>
    <tbody>
        <td>
            <th>
            </th>
        </td>
    </tbody>
</table>
