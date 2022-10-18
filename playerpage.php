<?php include_once 'header.php';

$params = null;
$params['fld'] = 'ID';
$params['opp'] = '!=';
$params['val'] = '';
$teams = new teams();
$teams = $teams->FindAllByParams($params);

?>
<style>

    h1 {
        text-align: center;
    }

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
            <th scope="col" style="width:14%">Name</th>
            <th scope="col" style="width:9%">Phone Number</th>
            <th scope="col" style="width:9%">Email</th>
            <th scope="col" style="width:9%">Gender</th>
            <th scope="col" style="width:9%">Height</th>
            <th scope="col" style="width:9%">Date of Birth</th>
            <th scope="col" style="width:10%">Jersey</th>
            <!-- Place a checkbox/button here -->
            <th scope="col" style="width:9%">Have They Paid</th>
            <!-- Place a checkbox/button here -->
            <th scope="col" style="width:14%">Anticipated Days Missed</th>
            <th scope="col" style="width:9%">Playoffs</th>
            <th scope="col" style="width:9%">Buddy Request</th>
            <th scope="col" style="width:9%">Willing to be Captain?</th>
            <th scope="col" style="width:8%">Waiver Agreement</th>
            <th scope="col" style="width:8%">Conditions/Illness/Injuries</th>
            <th scope="col" style="width:8%">Experience</th>
            <th scope="col" style="width:8%">Throwing</th>
            <th scope="col" style="width:8%">Cutting</th>
            <th scope="col" style="width:8%">Speed</th>
            <th scope="col" style="width:8%">Conditioning</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <p>Josh</p>
            </td>
            <td>
                <p>901-XXX-XXXX</p>
            </td>
            <td>
                <p>XXXX@XXXXX.XXX</p>
            </td>
            <td>
                <p>Helicopter</p>
            </td>
            <td>
                <p>6"</p>
            </td>
            <td>
                <p>02/29/2000</p>
            </td>
                <td>
                    <input type="checkbox" id="jersey1" name="jersey1" value="YesJ">
                </td>
                <td>
                    <input type="checkbox" id="paid1" name="paid1" value="YesP">
                </td>
            <td>
                <p>3</p>
            </td>
            <td>
                <input type="checkbox" id="answer1" name="answer1" value="YesY">
            </td>
            <td>
                <p>Josh Glaser</p>
            </td>
            <td>
                <input type="checkbox" id="answer1" name="answer1" value="YesY">
            </td>
            <td>
                <p>Yes</p>
            </td>
            <td>
                <p>Asthma</p>
            </td>
            <td>
                <p>0</p>
            </td>
            <td>
                <p>4</p>
            </td>
            <td>
                <p>3</p>
            </td>
            <td>
                <p>1</p>
            </td>
            <td>
                <p>2</p>
            </td>
        </tr>
    </tbody>
</table>
