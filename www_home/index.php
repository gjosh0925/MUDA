<?php
include_once 'header.php';
global $pageUser;
$schedule1 = new schedule('1');
$schedule1->setField(1);
$schedule2 = new schedule('2');
$schedule2->setField(2);
$schedule3 = new schedule('3');
$schedule3->setField(3);
$schedule4 = new schedule('4');
$schedule4->setField(4);
$schedule5 = new schedule('5');
$schedule5->setField(1);
$schedule6 = new schedule('6');
$schedule6->setField(2);
$schedule7 = new schedule('6');
$schedule7->setField(3);
$schedule8 = new schedule('6');
$schedule8->setField(4);



?>
<!--
<div class="a">
    <img src="images/muda_logo_black_horizontal.png" width="40%" height="40%">
</div>
-->

<div class="info-blurb">
    <b><u>Season Info</u></b>
    <p>
        This season we are excited to be playing at Overton Park in Memphis!<br>
        <b>Address:</b> 1914 Poplar Ave #202, Memphis, TN 38104
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
                    <th scope="row" style="text-align: center"><?php echo $schedule1->getField(); ?></th>
                    <td>Andrew (Blue)</td>
                    <td>VS</td>
                    <td>Justin (Purple)</td>
                    <td colspan="2" style="text-align: right">6-5</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"><?php echo $schedule2->getField(); ?></th>
                    <td>Evan (Black)</td>
                    <td>VS</td>
                    <td>Eric (Pink)</td>
                    <td colspan="2" style="text-align: right">6-9</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"><?php echo $schedule3->getField(); ?></th>
                    <td>Mary (Green)</td>
                    <td>VS</td>
                    <td>Walls (Orange)</td>
                    <td colspan="2" style="text-align: right">2-6</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"><?php echo $schedule4->getField(); ?></th>
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
                    <th scope="row" style="text-align: center"><?php echo $schedule5->getField(); ?></th>
                    <td>Andrew (Blue)</td>
                    <td>VS</td>
                    <td>Evan (Black)</td>
                    <td colspan="2" style="text-align: right">8-6</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"><?php echo $schedule6->getField(); ?></th>
                    <td>Andre (White)</td>
                    <td>VS</td>
                    <td>Eric (Pink)</td>
                    <td colspan="2" style="text-align: right">9-7</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"><?php echo $schedule7->getField(); ?></th>
                    <td>Mary (Green)</td>
                    <td>VS</td>
                    <td>Justin (Purple)</td>
                    <td colspan="2" style="text-align: right">6-10</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: center"><?php echo $schedule8->getField(); ?></th>
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
<!--
<?php if (!isset($pageUser)) { ?>
    <button onclick="location.href = 'login.php';">Login</button>
<?php } else { ?>
    <button onclick="location.href = 'logout.php';">Logout</button>
<?php } ?>
-->

<?php
include_once 'footer.php';
?>
