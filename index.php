<?php
include_once 'header.php';
global $pageUser;


$params = null;
$params['fld'] = 'Active';
$params['val'] = '1';
$season = new season();
$season = $season->FindByParams($params);

?>

<script>

    $(function () {
        <?php if(isset($_GET['success']) && isset($_SESSION['success'])){ ?>
            <?php if($_GET['success'] == "new_season_created" && $_SESSION['success'] == '1') { unset($_SESSION['success']); ?>
                $('#successBanner').html("New season created successfully!")
                showSuccessBanner();
            <?php } else if($_GET['success'] == "logged_in" && $_SESSION['success'] == '1') { unset($_SESSION['success']); ?>
                $('#successBanner').html("Logged in successfully!")
                showSuccessBanner();
            <?php } ?>
        <?php } ?>

        populateSchedule();

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
                    if (Object.keys(reply.schedules).length == 0){
                        $('#seasonTable tbody').html('No schedule has been published yet.');
                    } else {
                        let games = '';
                        for(var i = 0; i < Object.keys(reply.schedules).length; i++){
                            games += '<tr>' +
                                '<td>' + reply.schedules[i].Date + '</td>' +
                                '<td>' + reply.schedules[i].Field + '</td>' +
                                '<td>' + reply.schedules[i].TeamOne + '</td>' +
                                '<td>' + reply.schedules[i].TeamTwo + '</td>' +
                                '<td>' + reply.schedules[i].Score + '</td>' +
                                '<tr>';
                        }

                        $('#seasonTable tbody').html(games);

                    }
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

<style>
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
</style>

<h1 style="text-align:center"><?php echo $season->getName(); ?></h1>
<h2 style="text-align:center"><?php echo date('m/d/Y',strtotime($season->getStartDate())) .  " - " . date('m/d/Y',strtotime($season->getEndDate()));?></h2>

<div id="seasonInfo" style="padding-top: 5%; padding-left: 33%; text-align: left;">
    <b><u>Season Info</u></b>
    <p>
        <?php echo $season->getInfo()?><br>
        <b></b>
    </p>
</div>


<!--<div id="seasonDiv">-->
<!--    <div class="row" style="padding-bottom: 1%; padding-top: 1%">-->
<!--        <div class="column">-->
<!---->
<!--        </div>-->
<!--        <div class="column" style="text-align: center">-->
<!--            <h3> 10/16/2022 - Monday</h3>-->
<!--        </div>-->
<!--        <div class="column" style="padding-left: 6.5%">-->
<!--            <label for="weeks"></label>-->
<!--            <select name="weeks" id="weeks">-->
<!--                <option value="week1">10/02</option>-->
<!--                <option value="week2">10/09</option>-->
<!--                <option value="week3">10/16</option>-->
<!--                <option value="week4">10/23</option>-->
<!--                <option value="week5">10/30</option>-->
<!--                <option value="week6">11/06</option>-->
<!--                <option value="week7">11/13</option>-->
<!--                <option value="week8">11/20</option>-->
<!--            </select>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div style="display:flex; justify-content: center;">-->
<!--        <div style="justify-content: center" class="tble1-spacing">-->
<!--            <div class="card">-->
<!--                <table class="table table-striped" >-->
<!--                    <thead style="background-color: #00b2a9">-->
<!--                    <tr>-->
<!--                        <th scope="col">Field</th>-->
<!--                        <th scope="col" colspan="4" style="text-align: center">Game 1 (6-6:55)</th>-->
<!--                        <th scope="col">Score</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody>-->
<!--                    <tr>-->
<!--                        <th scope="row" style="text-align: center"></th>-->
<!--                        <td>Andrew (Blue)</td>-->
<!--                        <td>VS</td>-->
<!--                        <td>Justin (Purple)</td>-->
<!--                        <td colspan="2" style="text-align: right">6-5</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th scope="row" style="text-align: center"></th>-->
<!--                        <td>Evan (Black)</td>-->
<!--                        <td>VS</td>-->
<!--                        <td>Eric (Pink)</td>-->
<!--                        <td colspan="2" style="text-align: right">6-9</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th scope="row" style="text-align: center"></th>-->
<!--                        <td>Mary (Green)</td>-->
<!--                        <td>VS</td>-->
<!--                        <td>Walls (Orange)</td>-->
<!--                        <td colspan="2" style="text-align: right">2-6</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th scope="row" style="text-align: center"></th>-->
<!--                        <td>Andre (White)</td>-->
<!--                        <td>VS</td>-->
<!--                        <td>Kathleen (Red)</td>-->
<!--                        <td colspan="2" style="text-align: right">5-9</td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div style="justify-content: center" class="tble2-spacing">-->
<!--            <div class="card">-->
<!--                <table class="table table-striped" >-->
<!--                    <thead style="background-color: #00b2a9">-->
<!--                    <tr>-->
<!--                        <th scope="col">Field</th>-->
<!--                        <th scope="col" colspan="4" style="text-align: center">Game 2 (7:05-8)</th>-->
<!--                        <th scope="col">Score</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody>-->
<!--                    <tr>-->
<!--                        <th scope="row" style="text-align: center"></th>-->
<!--                        <td>Andrew (Blue)</td>-->
<!--                        <td>VS</td>-->
<!--                        <td>Evan (Black)</td>-->
<!--                        <td colspan="2" style="text-align: right">8-6</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th scope="row" style="text-align: center"></th>-->
<!--                        <td>Andre (White)</td>-->
<!--                        <td>VS</td>-->
<!--                        <td>Eric (Pink)</td>-->
<!--                        <td colspan="2" style="text-align: right">9-7</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th scope="row" style="text-align: center"></th>-->
<!--                        <td>Mary (Green)</td>-->
<!--                        <td>VS</td>-->
<!--                        <td>Justin (Purple)</td>-->
<!--                        <td colspan="2" style="text-align: right">6-10</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th scope="row" style="text-align: center"></th>-->
<!--                        <td>Walls (Orange)</td>-->
<!--                        <td>VS</td>-->
<!--                        <td>Kathleen (Red)</td>-->
<!--                        <td colspan="2" style="text-align: right">7-8</td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div style="display:flex; justify-content: center;">
    <table id="seasonTable" class="table" style="width: 80%;">
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

        </tbody>
    </table>
</div>

<?php
include_once 'footer.php';
?>
