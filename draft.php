<?php

include_once 'header.php';
global $pageUser;

//find the page users team ID
$params = null;
$params['fld'] = 'CaptainID';
$params['val'] = $pageUser->getID();
$pageUserTeam = new teams();
$pageUserTeam = $pageUserTeam->FindAllByParams($params);

//get all captains
$params = null;
$params['fld'] = 'UserRole';
$params['val'] = 'captain';
$captains = new user();
$captains = $captains->FindAllByParams($params, "DraftOrder");

?>

<script>
    $(function(){
        getDraftablePlayers();
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
                    console.log(reply.error);
                } else {
                    $('#available-players').html('');
                    var row = '';
                    if (jQuery.isEmptyObject(reply.availablePlayers)) {

                    } else {
                        for (var i = 0; i < Object.keys(reply.availablePlayers).length; i++) {
                            row += '<tr id="' + reply.availablePlayers[i]._ID + '" onclick="populatePickedPlayerModal(\'' + reply.availablePlayers[i]._ID + '\', \'' + reply.availablePlayers[i]._Buddy + '\');">'
                                 + '<td>' + reply.availablePlayers[i]._Nickname + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Throwing + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Cutting + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Speed + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Conditioning + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Experience + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Buddy + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Height + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Gender + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Absence + '</td>'
                                 + '<td>' + (reply.availablePlayers[i]._Playoffs == '1' ? 'Yes' : 'No') + '</td>'
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
                            div += '<div>' + reply.pickedPlayers[i]._Nickname + '</div>';

                            if (reply.pickedPlayers[i]._TeamID == '<?php echo $pageUser->getTeamID(); ?>') {
                                row += '<tr id="' + reply.pickedPlayers[i]._ID + '">'
                                    + '<td>' + reply.pickedPlayers[i]._Nickname + '</td>'
                                    + '<td>' + reply.pickedPlayers[i]._Throwing + '</td>'
                                    + '<td>' + reply.pickedPlayers[i]._Cutting + '</td>'
                                    + '<td>' + reply.pickedPlayers[i]._Speed + '</td>'
                                    + '<td>' + reply.pickedPlayers[i]._Conditioning + '</td>'
                                    + '<td>' + reply.pickedPlayers[i]._Experience + '</td>'
                                    + '<td>' + reply.pickedPlayers[i]._Buddy + '</td>'
                                    + '<td>' + reply.pickedPlayers[i]._Height + '</td>'
                                    + '<td>' + reply.pickedPlayers[i]._Gender + '</td>'
                                    + '<td>' + reply.pickedPlayers[i]._Absence + '</td>'
                                    + '<td>' + (reply.pickedPlayers[i]._Playoffs == '1' ? 'Yes' : 'No') + '</td>'
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
                console.log('Message: ' + message);
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

</style>

<h1 style="text-align:center;">The Draft</h1>

<div id="draftOrderDiv">
    <?php foreach ($captains as $captain) {
        echo "<p id='draftOrder'" . $captain->getID() . ">" . $captain->getNickName() . "</p>";
    }
    ?>
    <p class="turn">John Doe</p>
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

    <div style="width: 14%; height: 40vh; padding: .5%; margin:.5%; border: 4px solid #0c2340; border-radius: 15px;">
        <h3>Picked Players</h3>
        <div id="picked-players">
        </div>
    </div>

    <div style="width: 14%; height: 40vh; padding: .5%; margin:.5%; border: 4px solid #0c2340; border-radius: 15px;">
        <h3>Reserved Players</h3>
        <div id="reserved-players">
        </div>
    </div>


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
    var ctx = document.getElementById("myChart").getContext("2d");

    var data = {
        labels: ["Throwing", "Cutting", "Speed", "Conditioning", "Experience"],
        datasets: [{
            label: "Team1",
            backgroundColor: "blue",
            data: [3, 2, 4, 5, 4]
        }, {
            label: "Team2",
            backgroundColor: "red",
            data: [4, 3, 5, 2, 2]
        }, {
            label: "Team3",
            backgroundColor: "green",
            data: [5, 2, 1, 4, 3]
        }, {
            label: "Team4",
            backgroundColor: "purple",
            data: [2, 2, 5, 3, 4]
        }, {
            label: "Team5",
            backgroundColor: "pink",
            data: [1, 2, 5, 3, 3]
        }]
    };

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
</script>

<?php
include_once 'footer.php';
?>