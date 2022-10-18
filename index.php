<?php
include_once 'header.php';
global $pageUser;


$params = null;
$params['fld'] = 'Active';
$params['val'] = '1';
$season = new season();
$season = $season->FindAllByParams($params);



foreach($season as $s) {
    $currseason = new season($s->getID());
}


?>
<h1 style="text-align:center"><?php echo $currseason->getName(); ?></h1>
<h2 style="text-align:center"><?php echo $currseason->getStartDate() .  " - " . $currseason->getEndDate();?></h2>

<div style="padding-top: 5%; padding-left: 33%; text-align: left;">
    <b><u>Season Info</u></b>
    <p>
        <?php echo $currseason->getInfo()?><br>
        <b></b>
    </p>
</div>

<div style="display:flex; justify-content: center;">
    <div style="justify-content: center" class="tble1-spacing">
        <div class="card">
            <table class="table table-striped" >
                <thead style="background-color: #00b2a9">
                <tr>
                    <th scope="col">Field</th>
                    <th scope="col" colspan="4" style="text-align: center">Game 1 (6-6:55)</th>
                    <th scope="col">Score</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row" style="text-align: center"></th>
                    <td>Andrew (Blue)</td>
                    <td>VS</td>
                    <td>Justin (Purple)</td>
                    <td colspan="2" style="text-align: right">6-5</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"></th>
                    <td>Evan (Black)</td>
                    <td>VS</td>
                    <td>Eric (Pink)</td>
                    <td colspan="2" style="text-align: right">6-9</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"></th>
                    <td>Mary (Green)</td>
                    <td>VS</td>
                    <td>Walls (Orange)</td>
                    <td colspan="2" style="text-align: right">2-6</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"></th>
                    <td>Andre (White)</td>
                    <td>VS</td>
                    <td>Kathleen (Red)</td>
                    <td colspan="2" style="text-align: right">5-9</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div style="justify-content: center" class="tble2-spacing">
        <div class="card">
            <table class="table table-striped" >
                <thead style="background-color: #00b2a9">
                <tr>
                    <th scope="col">Field</th>
                    <th scope="col" colspan="4" style="text-align: center">Game 2 (7:05-8)</th>
                    <th scope="col">Score</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row" style="text-align: center"></th>
                    <td>Andrew (Blue)</td>
                    <td>VS</td>
                    <td>Evan (Black)</td>
                    <td colspan="2" style="text-align: right">8-6</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"></th>
                    <td>Andre (White)</td>
                    <td>VS</td>
                    <td>Eric (Pink)</td>
                    <td colspan="2" style="text-align: right">9-7</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"></th>
                    <td>Mary (Green)</td>
                    <td>VS</td>
                    <td>Justin (Purple)</td>
                    <td colspan="2" style="text-align: right">6-10</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"></th>
                    <td>Walls (Orange)</td>
                    <td>VS</td>
                    <td>Kathleen (Red)</td>
                    <td colspan="2" style="text-align: right">7-8</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once 'footer.php';
?>
