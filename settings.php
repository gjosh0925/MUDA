<?php

include_once 'header.php';
global $pageUser;

if (!isset($pageUser)){
    header("Location: index.php");
} else if ($pageUser->getUserRole() == 'captain') {
    header("Location: index.php");
}

$params = null;
$params['fld'] = 'Active';
$params['val'] = '1';
$season = new season();
$season = $season->FindByParams($params);

$params = null;
$params['fld'] = 'DraftOrder';
$params['opp'] = '!=';
$params['val'] = '-1';
$captains = new user();
$captains = $captains->FindAllByParams($params, 'DraftOrder');

$params = null;
$params['fld'] = 'ID';
$params['opp'] = '!=';
$params['val'] = '';
$schedules = new schedule();
$schedules = $schedules->FindAllByParams($params, 'Date, Field');

$params = null;
$params['fld'] = 'ID';
$params['opp'] = '!=';
$params['val'] = '';
$teams = new teams();
$teams = $teams->FindAllByParams($params);

?>

<script>

    function updateDraftOrder(elem){
        let input = $(elem).val();
        let clone = '';
        if (input < '1' || input > $(".order").length) {
            console.log('input too big or too small');
            $('.order input').each(function(i, val){
                $(val).val(i + 1);
            });
        } else {
            clone = $(elem).parent();
            $(elem).parent().remove();
            let newOrder = '';

            if (input == ($('.order').length + 1)) {
                $('#draftOrderDiv').append('<div class="order">' + $(clone).html() + '</div>');
            } else {
                $('#draftOrderDiv .order').each(function(i, val){
                    if ((i + 1) == input){
                        newOrder += '<div class="order" onclick="">' + $(clone).html() + '</div>';
                    }
                    newOrder += '<div class="order">' + $(val).html() + '</div>';
                });
                $('#draftOrderDiv').html(newOrder);
            }
            $('.order input').each(function(i, val){
                $(val).val(i + 1);
            });
        }

        submitDraftOrder();
    }

    function submitDraftOrder(){

        let captainIDs = [];

        $('.order input').each(function(i){
           captainIDs.push($(this).attr('id'));
        });

        console.log(captainIDs);

        var datapacket = {
            TODO: 'submitDraftOrder',
            NewOrder: captainIDs
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
                    // seasonCreated();
                }
            },
            error: function(message, obj, error){
                console.log('Message: ' + message);
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }

    function submitSeasonInfo(){
        var datapacket = {
            TODO: 'submitSeasonInfo',
            SeasonID: '<?php echo $season->getID(); ?>',
            Name: $('input[name=season_name]').val(),
            StartDate: $('input[name=start_date]').val(),
            EndDate: $('input[name=end_date]').val(),
            PlayoffDate: $('input[name=playoff_date]').val(),
            Info: $('#seasonInfoTextBox').val()
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

                }
            },
            error: function(message, obj, error){
                console.log('Message: ' + message);
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }

    function addGameToSchedule(){
        var datapacket = {
            TODO: 'addGameToSchedule',
            ID: $('#modalScheduleID').html(),
            Date: $('input[name=new_game_date]').val(),
            Time: $('input[name=new_game_time]').val(),
            Field: $('input[name=new_game_field]').val(),
            TeamOne: $('#new_game_teamOne').val(),
            TeamTwo: $('#new_game_teamTwo').val(),
            ScoreOne: $('input[name=new_game_scoreOne]').val(),
            ScoreTwo: $('input[name=new_game_scoreTwo]').val()
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
                    window.location = 'settings.php';
                }
            },
            error: function(message, obj, error){
                console.log('Message: ' + message);
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }

    function populateScheduleModal(id){
        var datapacket = {
            TODO: 'populateScheduleModal',
            ID: id
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
                    let score1 = '';
                    let score2 = '';
                    if (reply.scoreOne !== '-1'){
                        score1 = reply.scoreOne;
                    }
                    if (reply.scoreTwo !== '-1'){
                        score2 = reply.scoreTwo;
                    }
                    $('input[name=new_game_date]').val(reply.date);
                    $('input[name=new_game_time]').val(reply.time);
                    $('input[name=new_game_field]').val(reply.field);
                    $('#new_game_teamOne').val(reply.teamOne);
                    $('#new_game_teamTwo').val(reply.teamTwo);
                    $('input[name=new_game_scoreOne]').val(score1);
                    $('input[name=new_game_scoreTwo]').val(score2);
                    $('#modalScheduleTitle').html('Edit Game');
                    $('#modalScheduleID').html(reply.ID);
                }
                $('#addGameModal').modal('show');
            },
            error: function(message, obj, error){
                console.log('Message: ' + message);
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }

    function populateNewScheduleModal(){
        $('input[name=new_game_date]').val('');
        $('input[name=new_game_time]').val('');
        $('input[name=new_game_field]').val('');
        $('#new_game_teamOne').val('');
        $('#new_game_teamTwo').val('');
        $('#modalScheduleID').html('');
        $('input[name=new_game_scoreOne]').val('');
        $('input[name=new_game_scoreTwo]').val('');
        $('#modalScheduleTitle').html('Add new Game');

        $('#addGameModal').modal('show');
    }

</script>

<style>

    .section{
        border: 3px solid #0c2340;
        border-radius: 20px;
        margin: 20px;
    }

    .order{
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

</style>

<h1 style="text-align:center;">Settings</h1>

<div style="display:flex; justify-content: space-around;">
    <div id="seasonInfo" class="section" style="width: 35%;">
        <h4 style="text-align:center;">Edit Season</h4>
        <form style="padding: 20px;">
            <label>Season Name</label>
            <input class="form-control" type="text" onchange="submitSeasonInfo();" name="season_name" value="<?php echo $season->getName(); ?>"><br>
            <div style="display:flex; justify-content: space-between; flex-wrap: wrap;">
                <div style="display:flex; flex-direction: column">
                    <label>Start Date</label>
                    <input class="form-control" type="date" onchange="submitSeasonInfo();" name="start_date" value="<?php echo $season->getStartDate(); ?>"><br>
                </div>
                <div style="display:flex; flex-direction: column">
                    <label>End Date</label>
                    <input class="form-control" type="date" onchange="submitSeasonInfo();" name="end_date" value="<?php echo $season->getEndDate(); ?>"><br>
                </div>
                <div style="display:flex; flex-direction: column">
                    <label>Playoff Date</label>
                    <input class="form-control" type="date" onchange="submitSeasonInfo();" name="playoff_date" value="<?php echo $season->getPlayoffDate(); ?>"><br>
                </div>
            </div>
            <label>Season Info</label>
            <textarea class="form-control" id="seasonInfoTextBox" onchange="submitSeasonInfo();" name="info"><?php echo $season->getInfo(); ?></textarea>
        </form>
<!--        <div style="display: flex; justify-content: center;">-->
<!--            <button class="btn btn-secondary" onclick="submitSeasonInfo();" style="">Update Season</button>-->
<!--        </div>-->
    </div>
    <div id="scheduleInfo" class="section" style="width: 50%;">
        <h4 style="text-align: center;">Edit Schedule</h4>
        <?php //if (count($schedules) == 0) {?>
<!--                <div style="display:flex; justify-content:center;">-->
<!--                    <button onclick="window.location = 'create_schedule.php';" class="btn btn-primary">Create Schedule</button>-->
<!--                </div>-->
        <?php //} else { ?>
<!--            <p>Schedule Generated!</p>-->
        <?php //} ?>

        <?php if (count($schedules) !== 0) { ?>

        <table class="table sortable" style="margin:20px; width:95%;">
            <thead>
                <tr>
                    <th>Edit</th>
                    <th>Date</th>
                    <th>Field</th>
                    <th>Team 1</th>
                    <th>Team 2</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php $row = '';
                foreach($schedules as $schedule){
                    $teamOne = new teams($schedule->getTeamOneID());
                    $teamTwo = new teams($schedule->getTeamTwoID());
                    $score1 = '';
                    $score2 = '';
                    if ($schedule->getTeamOneScore() !== '-1') {
                        $score1 = $schedule->getTeamOneScore();
                    }
                    if ($schedule->getTeamTwoScore() !== '-1') {
                        $score2 = $schedule->getTeamTwoScore();
                    }
                    $row .= '<tr>'
                        . '<td><button onclick="populateScheduleModal(\'' . $schedule->getID() . '\')" class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i></button></td>'
                        . '<td>' . date('n/j/Y g:ia',strtotime($schedule->getDate())) . '</td>'
                        . '<td>' . $schedule->getField() . '</td>'
                        . '<td>' . $teamOne->getName() . '</td>'
                        . '<td>' . $teamTwo->getName() . '</td>'
                        . '<td>' . $score1 . '-' . $score2 . '</td>'
                    . '</tr>';
                }
                echo $row; ?>
            </tbody>
        </table>

        <?php } ?>
        <div style="display:flex; justify-content: center;">
            <button id="submitScheduleButton" onclick="populateNewScheduleModal();" class="btn btn-secondary" style="margin-bottom: 20px;">Add Game to Schedule</button>
        </div>
    </div>
    <div id="draftOrder" class="section" style="width: 15%; display:flex;  flex-direction: column; align-items: center;">
        <h4 style="text-align:center;">Edit Draft Order</h4>
        <div id="draftOrderDiv" style="display:flex; flex-direction: column;">
            <?php
            $draftOrder = '';
            foreach ($captains as $captain){
                $draftOrder .= '<div class="order"><input id="' . $captain->getID() . '" class="form-control" onchange="updateDraftOrder($(this));" style="width: 15%; height: 30px; text-align: center; padding: 0px !important;" value="' . $captain->getDraftOrder() . '"></input>' . $captain->getNickName() . '</div>';
            }

            echo $draftOrder;
            ?>
        </div>
<!--        <button class="btn btn-secondary" style="margin-bottom: 10px;" onclick="submitDraftOrder();">Update Order</button>-->
    </div>
</div>

<div class="modal fade" id="addGameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalScheduleTitle">Add new Game</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex; flex-wrap: wrap; justify-content: space-around;">
                <p id="modalScheduleID" style="display:none;"></p>
                <div>
                    <label>Date</label>
                    <input class="form-control" type="date" name="new_game_date"><br>
                </div>
                <div>
                    <label>Time</label>
                    <input class="form-control" type="time" name="new_game_time"><br>
                </div>
                <div>
                    <label>Field</label>
                    <input class="form-control" type="number" name="new_game_field" min="1" max="10"><br>
                </div>
                <div>
                    <label>Team 1</label>
                    <div class="input-group mb-3">
                        <select class="custom-select" id="new_game_teamOne">
                            <?php
                            $options = '<option disabled selected>Choose team</option>';
                            foreach ($teams as $team) {
                                $options .= '<option value="' . $team->getID() . '">' . $team->getName() . '</option>';
                            }
                            //$options .= '<option value="playoff">Playoffs</option>';
                            echo $options;
                            ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label>Team 2</label>
                    <div class="input-group mb-3">
                        <select class="custom-select" id="new_game_teamTwo">
                            <?php echo $options; ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label>Team 1 Score</label>
                    <input class="form-control" type="number" name="new_game_scoreOne"><br>
                </div>
                <div>
                    <label>Team 2 Score</label>
                    <input class="form-control" type="number" name="new_game_scoreTwo"><br>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: space-between;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="pickPlayer" type="button" class="btn btn-primary" onclick="addGameToSchedule();">Submit</button>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>
