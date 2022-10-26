<?php

include_once 'header.php';
global $pageUser;

//find the page users team ID
$params = null;
$params['fld'] = 'CaptainID';
$params['val'] = $pageUser->getID();
$pageUserTeam = new teams();
$pageUserTeam = $pageUserTeam->FindAllByParams($params);

?>

<script>
    $(function(){
        getDraftablePlayers();

        getAverageStats();
    });


    function getDraftablePlayers(player = ''){
        var datapacket = {
            TODO: 'draftPlayers',
            pickedPlayer: player,
            TeamID: '<?php echo $pageUser->getTeamID(); ?>'
        };
        $.ajax({
            type:"POST",
            url: SiteURL,
            data:datapacket,
            dataType:"json",
            crossDomain: true,
            success: function(reply){
                if (reply.error === true){

                } else {
                    let draftNames = '';
                    for(var i = 0; i < reply.draftOrderCount; i++){
                        if ((i + 1) == reply.draftTurn){
                            draftNames += '<p class="turn">' + reply.draftOrder[i] + '</p>'; //add id (id="draftOrder + id)
                        } else {
                            draftNames += '<p>' + reply.draftOrder[i] + '</p>'; //add id (id="draftOrder + id)
                        }
                    }
                    $('#draftOrderDiv').html(draftNames);

                    $('#available-players').html('');
                    var row = '';
                    if (jQuery.isEmptyObject(reply.availablePlayers)) {

                    } else {

                        for (var i = 0; i < Object.keys(reply.availablePlayers).length; i++) {
                            if (reply.draftTurn == <?php echo $pageUser->getDraftOrder(); ?>){
                                row += '<tr id="' + reply.availablePlayers[i].id + '" onclick="populatePickedPlayerModal(\'' + reply.availablePlayers[i].id + '\', \'' + reply.availablePlayers[i].buddy + '\');">';
                            } else {
                                row += '<tr id="' + reply.availablePlayers[i].id + '" onclick="showNotYourTurn();">';
                            }
                            row += '<td>' + reply.availablePlayers[i].name + '</td>'
                                + '<td>' + reply.availablePlayers[i].throwing + '</td>'
                                + '<td>' + reply.availablePlayers[i].cutting + '</td>'
                                + '<td>' + reply.availablePlayers[i].speed + '</td>'
                                + '<td>' + reply.availablePlayers[i].conditioning + '</td>'
                                + '<td>' + reply.availablePlayers[i].experience + '</td>'
                                + '<td>' + reply.availablePlayers[i].buddy + '</td>'
                                + '<td>' + reply.availablePlayers[i].height + '</td>'
                                + '<td>' + reply.availablePlayers[i].gender + '</td>'
                                + '<td>' + reply.availablePlayers[i].absence + '</td>'
                                + '<td>' + reply.availablePlayers[i].playoffs + '</td>'
                                + '</tr>';
                        }

                        $('#available-players').append(row);
                    }

                    $('#yourTeam').html('');
                    $('#picked-players').html('');
                    var row = '';
                    var div = '';
                    if (jQuery.isEmptyObject(reply.pickedPlayers)) {

                    } else {

                        for (var i = 0; i < Object.keys(reply.pickedPlayers).length; i++) {
                            div += '<div>' + reply.pickedPlayers[i].name + '</div>';

                            if (reply.pickedPlayers[i].teamid == '<?php echo $pageUser->getTeamID(); ?>') {
                                row += '<tr id="' + reply.pickedPlayers[i].id + '">'
                                    + '<td>' + reply.pickedPlayers[i].name + '</td>'
                                    + '<td>' + reply.pickedPlayers[i].throwing + '</td>'
                                    + '<td>' + reply.pickedPlayers[i].cutting + '</td>'
                                    + '<td>' + reply.pickedPlayers[i].speed + '</td>'
                                    + '<td>' + reply.pickedPlayers[i].conditioning + '</td>'
                                    + '<td>' + reply.pickedPlayers[i].experience + '</td>'
                                    + '<td>' + reply.pickedPlayers[i].buddy + '</td>'
                                    + '<td>' + reply.pickedPlayers[i].height + '</td>'
                                    + '<td>' + reply.pickedPlayers[i].gender + '</td>'
                                    + '<td>' + reply.pickedPlayers[i].absence + '</td>'
                                    + '<td>' + (reply.pickedPlayers[i].playoffs == '1' ? 'Yes' : 'No') + '</td>'
                                    + '</td>';
                            }
                        }

                        $('#yourTeam').append(row);
                        $('#picked-players').append(div);
                    }
                    $('#playersLeft').html('Players Left: ');
                    $('#playersLeft').append($('#available-players tr').length);
                }
            },
            error: function(message, obj, error){
                console.log('Message: ' + JSON.stringify(message));
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }

    function populatePickedPlayerModal(playerID, buddy){
        $('#confirmPick .modal-body').html('');
        var playerName = $('#' + playerID).children('td:first').html();

        if (buddy != '') {
            var buddy = '<div class="alert alert-warning" role="alert">This player has <b>' + buddy + '</b> as their buddy. Please select them for your next pick.</div>';
            $('#confirmPick .modal-body').append(buddy);

        }

        $('#confirmPick .modal-body').append("<b><p style='font-size: 30px;text-align: center;'>" + playerName + "</p></b>");
        $('#pickPlayer').attr('onclick', 'getDraftablePlayers("' + playerID + '"); $("#confirmPick").modal("hide");');
        $('#confirmPick').modal('show');
    }

    function showNotYourTurn(){
        $('#notYourTurnAlert').show();
        setTimeout(function() {
            $('#notYourTurnAlert').slideUp(1000);
        }, 3000);
    }


</script>

<style>
    p{
        margin-bottom: 0px;
    }

    #available-players tr:hover {
        background-color: #f1f0f0;
        cursor: pointer;
    }

    #yourTeam tr:hover {
        background-color: #f1f0f0;
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

    #draftOrderDiv {
        background-color: #0c2340;
        color: white;
        border-radius: 15px;
        margin: 10px;
        display: flex;
        justify-content: space-around;
        flex-direction: row;
        align-items: center;
        height: 10%;
    }

    .turn {
        background-color: #00b2a9;
        border-radius: 10px;
        border: 3px solid white;
        padding: 10px;
    }

    .error-alert {
        position: absolute !important;
        z-index: 1;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        width: 25%;
        height: 10%;
        font-size: 24px;
        top: 90px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

</style>

<div id="notYourTurnAlert" class="alert alert-danger error-alert" role="alert" style="display:none;">
    It is not your turn to pick a player.
</div>

<h1 style="text-align:center;">The Draft</h1>

<div id="draftOrderDiv">
</div>

<div style="display: flex; flex-direction: row; flex-wrap: wrap; align-items:flex-start;">
    <div id="players" style="width: 69%; height:40vh; overflow:auto; padding: .5%; margin:.5%; border: 4px solid #0c2340; border-radius: 15px;">
        <div style='display: flex; justify-content: space-between;'>
            <h3>Available Players</h3>
            <h3 id="playersLeft">Players Left: </h3>
        </div>
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
            <tbody id="available-players">
            </tbody>
        </table>
    </div>

    <div style="/*width: 14%;*/ width: 29%; height: 40vh; padding: .5%; margin:.5%; border: 4px solid #0c2340; border-radius: 15px; overflow:auto;">
        <h3>Picked Players</h3>
        <div id="picked-players">
        </div>
    </div>

<!--    <div style="width: 14%; height: 40vh; padding: .5%; margin:.5%; border: 4px solid #0c2340; border-radius: 15px;">-->
<!--        <h3>Reserved Players</h3>-->
<!--        <div id="reserved-players">-->
<!--        </div>-->
<!--    </div>-->


    <div style="width: 69%; height: 40vh; padding: .5%; margin:.5%; overflow:auto; border: 4px solid #0c2340; border-radius: 15px;">
        <h3>Your Team</h3>
        <table class="table sortable">
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
            <tbody id="yourTeam">
            </tbody>
        </table>
    </div>

    <div id="stats" style="width: 29%; height: 40vh; padding: .5%; margin:.5%; border: 4px solid #0c2340; border-radius: 15px;">
        <h3>Average Stats</h3>
        <canvas id="myChart" style="width:100%;max-width:600px;"></canvas>
    </div>
</div>


<div class="modal fade" id="confirmPick" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to pick this player?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="">

            </div>
            <div class="modal-footer" style="justify-content: space-between;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="pickPlayer" type="button" class="btn btn-primary">Pick Player</button>
            </div>
        </div>
    </div>
</div>

<script>

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function getAverageStats(){
        var datapacket = {
            TODO: 'getAverageStats'
        };
        $.ajax({
            type:"POST",
            url: SiteURL,
            data:datapacket,
            dataType:"json",
            crossDomain: true,
            success: function(reply){
                if (reply.error === true){

                } else {

                    var ctx = document.getElementById("myChart").getContext("2d");

                    var data = {
                        labels: ["Throwing", "Cutting", "Speed", "Conditioning", "Experience"],
                        datasets: []
                    };
                    let stats = '';
                    for(var i = 0; i < Object.keys(reply.averageStats).length; i++){
                        data.datasets.push({label: reply.averageStats[i].teamName, backgroundColor: getRandomColor(),
                            data:
                                [reply.averageStats[i].throwing,
                                    reply.averageStats[i].cutting,
                                    reply.averageStats[i].speed,
                                    reply.averageStats[i].conditioning,
                                    reply.averageStats[i].experience
                                ]});
                    }

                    var myBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            barValueSpacing: 20,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        min: 0,
                                    }
                                }]
                            }
                        }
                    });

                }
            },
            error: function(message, obj, error){
                console.log('Message: ' + JSON.stringify(message));
                console.log('Obj: ' + obj);
                console.log('Error: ' + error);
            }
        });
    }

</script>

<?php
include_once 'footer.php';
?>