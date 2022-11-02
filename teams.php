<?php include_once 'header.php';

$params = null;
$params['fld'] = 'ID';
$params['opp'] = '!=';
$params['val'] = '';
$teams = new teams();
$teams = $teams->FindAllByParams($params);

if (isset($_GET['teamid'])) {
    $params = null;
    $params['fld'] = 'TeamID';
    $params['val'] = $_GET['teamid'];
    $players = new user();
    $players = $players->FindAllByParams($params, 'Nickname');

    $params = null;
    $params['fld'] = 'ID';
    $params['opp'] = '!=';
    $params['val'] = '';
    $schedules = new schedule();
    $schedules = $schedules->FindAllByParams($params, 'Date, Field');

    $team = new teams($_GET['teamid']);

    $params = null;
    $params['fld'] = 'ID';
    $params['val'] = $team->getCaptainID();
    $captain = new user();
    $captain = $captain->FindByParams($params);

}


?>

<style>

    h1 {text-align: center;}

    /*code {*/
    /*    font-family: Consolas,"courier new";*/
    /*    color: crimson;*/
    /*    background-color: #f1f1f1;*/
    /*    padding: 2px;*/
    /*    font-size: 105%;*/
    /*}*/

    /*table, th, td {*/
    /*    border: 1px solid black;*/
    /*    border-radius: 10px;*/

    /*    padding-top: 10px;*/
    /*    padding-bottom: 20px;*/
    /*    padding-left: 30px;*/
    /*    padding-right: 40px;*/
    /*    border-spacing: 100px;*/

    /*    color: white;*/
    /*    font-size: 105%;*/
    /*}*/

    /*tr{*/
    /*    style: width:150%;*/
    /*    style: height:200px;*/
    /*}*/

    /*table.center {*/
    /*    margin-left: auto;*/
    /*    margin-right: auto;*/
    /*}*/

    .teamNames {
        border: 4px solid #0c2340;
        border-radius: 20px;
        padding: 40px 0 40px 0;
        margin: 50px;
        font-size: 24px;
        background-color: #00b2a9;
        color: white;
        text-align: center;
        width: 15%;
    }

    td, tr {
        border: 2px solid #0c2340;
    }

    th {
        background-color: #00b2a9;
        color: #0c2340;
        cursor: pointer;
        border-bottom: 3px solid #0c2340 !important;
    }

    table {
        border: 3px solid #0c2340 !important;
    }

    .players{
        display:flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border: 3px solid #0c2340;
        border-radius: 10px;
        margin: 10px;
        background-color: #00b2a9;
        color: white;
        width: 45%;
    }

    .section{
        border: 3px solid #0c2340;
        border-radius: 20px;
        margin: 20px;
    }

    h3{
        margin: 10px;
    }

</style>

<?php if (!isset($_GET['teamid'])) { ?>
    <h1>League's Teams</h1>

    <div style="display:flex; flex-wrap: wrap; justify-content: space-evenly; padding: 100px;">
        <?php foreach($teams as $team) {
            $teamDiv = '<div class="teamNames" onclick="window.location.href = \'teams.php?teamid=' . $team->getID() . '\'">' . $team->getName() . '</div>';
            echo $teamDiv;
        } ?>
    </div>

<?php } else { ?>
    <div>
        <button class="btn btn-secondary" style="float:left; margin: 20px;" onclick="window.location.href='teams.php'"><i class="fa-solid fa-arrow-left"></i>Back</button>
        <h1 style="margin-bottom: 40px;">Team <?php echo $team->getName(); ?></h1>
    </div>

    <div style="display: flex; justify-content: space-around;">
        <div style="display: flex; flex-direction: column; width: 40%;">
            <div class="section">
                <h3>Team Captain</h3>
                <p class="players"><?php echo $captain->getNickname(); ?></p>
            </div>

            <div class="section" style="display: flex; flex-direction: row; flex-wrap: wrap;">
                <h3 style="width: 100%;">Players</h3>
                <?php foreach ($players as $player){
                    if ($team->getCaptainID() !== $player->getID()){
                        echo "<p class='players'>". $player->getNickname(). "</p>";
                    }
                } ?>
            </div>
        </div>
        <div>
            <h3>Schedule</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Field</th>
                        <th>Team 1</th>
                        <th>Team 2</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                <?php $row = '';
                foreach ($schedules as $schedule) {
                    if ($schedule->getTeamOneID() == $team->getID() || $schedule->getTeamTwoID() == $team->getID()) {
                        $teamOne = new teams($schedule->getTeamOneID());
                        $teamTwo = new teams($schedule->getTeamTwoID());
                        $row .= '<tr>'
                            . '<td>' . date('n/j/Y g:ia',strtotime($schedule->getDate())) . '</td>'
                            . '<td>' . $schedule->getField() . '</td>'
                            . '<td>' . $teamOne->getName() . '</td>'
                            . '<td>' . $teamTwo->getName() . '</td>';
                        if ($schedule->getTeamOneScore() == '-1' || $schedule->getTeamTwoScore() == '-1') {
                            $row .= '<td></td>';
                        } else {
                            $row .= '<td>' . $schedule->getTeamOneScore() . '-' . $schedule->getTeamTwoScore() . '</td>';
                        }
                        $row .= '</tr>';
                    }
                }
                echo $row;?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>


<?php include_once 'footer.php'; ?>

