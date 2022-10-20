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

<script>

    $(function () {
        <?php if(isset($_GET['success']) && isset($_SESSION['success'])){ ?>
            <?php if($_GET['success'] == "new_season_created" && $_SESSION['success'] == '1') { unset($_SESSION['success']); ?>
                seasonCreated();
            <?php } else if($_GET['success'] == "logged_in" && $_SESSION['success'] == '1') { unset($_SESSION['success']); ?>
                loggedIn();
            <?php } ?>
        <?php } ?>

        //populateSchedule();

    });

    function populateSchedule(date = ''){
        var datapacket = {
            TODO: 'populateSchedule'
        };
        $.ajax({
            type:"POST",
            url: SiteURL,
            data:datapacket,
            dataType:"json",
            crossDomain: true,
            success: function(reply){
                if (reply.error === true){
                    console.log(reply.error);
                } else {
                    let table = '<table class="table table-striped">' +
                        '<thead>' +
                        '<tr>' +
                        '<td>Field</td>' +
                        '<td>Date</td>' +
                        '<td>Team One</td>' +
                        '<td>Team Two</td>' +
                        '<td>Score</td>' +
                        '</tr>' +
                        '</thead>' ;

                    for(var i = 0; i < Object.keys(reply.schedules).length; i++){
                        var row = '<tr>' +
                            '<td>' + reply.schedules[i]._Field + '</td>' +
                            '<td>' + reply.schedules[i]._Date + '</td>' +
                            '<td>' + reply.teamOneName[i] + '</td>' +
                            '<td>' + reply.teamTwoName[i] + '</td>' +
                            '<td>1 - 0</td>' +
                            '<tr>';
                        table += row;

                    }

                    table += '<tbody>' +
                        '</tbody>' +
                        '</table>';

                    $('#seasonDiv').html(table);

                }
            },
            error: function(message, obj, error){
                console.log('Message: ' + message);
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }

</script>

<h1 style="text-align:center"><?php echo $currseason->getName(); ?></h1>
<h2 style="text-align:center"><?php echo date('m/d/Y',strtotime($currseason->getStartDate())) .  " - " . date('m/d/Y',strtotime($currseason->getEndDate()));?></h2>

<div id="seasonInfo" style="padding-top: 5%; padding-left: 33%; text-align: left;">
    <b><u>Season Info</u></b>
    <p>
        <?php echo $currseason->getInfo()?><br>
        <b></b>
    </p>
</div>


<div id="seasonDiv">
    <div class="row" style="padding-bottom: 1%; padding-top: 1%">
        <div class="column">

        </div>
        <div class="column" style="text-align: center">
            <h3> 10/16/2022 - Monday</h3>
        </div>
        <div class="column" style="padding-left: 6.5%">
            <label for="weeks"></label>
            <select name="weeks" id="weeks">
                <option value="week1">10/02</option>
                <option value="week2">10/09</option>
                <option value="week3">10/16</option>
                <option value="week4">10/23</option>
                <option value="week5">10/30</option>
                <option value="week6">11/06</option>
                <option value="week7">11/13</option>
                <option value="week8">11/20</option>
            </select>
        </div>
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
</div>

<?php
include_once 'footer.php';
?>
