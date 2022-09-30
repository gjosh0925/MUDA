<?php

include_once 'header.php';
global $pageUser;

$user = new user('86d16a2b08a9479fba6edd0927ff755a');

//find the page users team ID
$params = null;
$params['fld'] = 'CaptainID';
$params['opp'] = '=';
//$params['val'] = $pageUser->getID();
$params['val'] = $user->getID();
$pageUserTeam = new teams();
$pageUserTeam = $pageUserTeam->FindAllByParams($params);


?>

<script>
    $(function(){
        getDraftablePlayers();
    });


    function getDraftablePlayers(player = ''){
        var datapacket = {
            TODO: 'draftPlayers',
            pickedPlayer: player,
            TeamID: '<?php echo $user->getTeamID(); ?>'
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
                    if (reply.availablePlayers == undefined) {

                    } else {
                        for (var i = 0; i < Object.keys(reply.availablePlayers).length; i++) {
                            row += '<tr id="' + reply.availablePlayers[i]._ID + '" onclick="populatePickedPlayerModal(\'' + reply.availablePlayers[i]._ID + '\');">'
                                 + '<td>' + reply.availablePlayers[i]._Nickname + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Throwing + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Cutting + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Speed + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Conditioning + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Experience + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Buddy + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Height + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Gender + '</td>'
                                 + '<td>' + reply.availablePlayers[i]._Playoffs + '</td>'
                                 + '</td>';
                        }
                        $('#available-players').append(row);
                    }

                    $('#yourTeam').html('');
                    $('#picked-players').html('');
                    var row = '';
                    var div = '';
                    if (reply.pickedPlayers == undefined) {

                    } else {
                        for (var i = 0; i < Object.keys(reply.pickedPlayers).length; i++) {
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
                                 + '<td>' + reply.pickedPlayers[i]._Playoffs + '</td>'
                                 + '</td>';


                            if (reply.pickedPlayers[i]._TeamID == '<?php echo $user->getTeamID(); ?>') {
                                div += '<div>' + reply.pickedPlayers[i]._Nickname + '</div>';
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
        var playerInfo = $('#' + playerID).children('td:first').html();;

        // $('#' + playerID + ' > td').each(function() {
        //     playerInfo+= '<div style="border-bottom: 2px solid black; height: 50px; text-align:center;">' + $(this).html() + '</div>';
        // });

        $('#confirmPick .modal-body').html("<b>" + playerInfo + "</b>");
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
    }

    table {
        border: 3px solid #0c2340 !important;
    }

    th {
        border-bottom: 3px solid #0c2340 !important;
    }
</style>

<h1 style="text-align:center;">The Draft</h1>
<div style="display: flex; flex-direction: row; flex-wrap: wrap; align-items:flex-start;">
    <div id="players" style="width: 69%; height:80vh; overflow:auto; padding: .5%; margin:.5%; border: 4px solid #0c2340; border-radius: 15px;">
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
                    <th scope="col" style="width:8%">Playoffs</th>
                </tr>
            </thead>
            <tbody id="available-players">
            </tbody>
        </table>
    </div>

    <div style="width: 29%; height: 80vh; padding: .5%; margin:.5%; border: 4px solid #0c2340; border-radius: 15px;">
        <h3>Picked Players</h3>
        <div id="picked-players">
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
                <th scope="col" style="width:8%">Playoffs</th>
            </tr>
            </thead>
            <tbody id="yourTeam">
            </tbody>
        </table>
    </div>

    <div id="stats" style="width: 29%; height: 40vh; padding: .5%; margin:.5%; border: 4px solid #0c2340; border-radius: 15px;">
        <h3>Average Stats</h3>
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
            <div class="modal-body" style="font-size: 30px;text-align: center;">

            </div>
            <div class="modal-footer" style="justify-content: space-between;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="pickPlayer" type="button" class="btn btn-primary">Pick Player</button>
            </div>
        </div>
    </div>
</div>


<?php
include_once 'footer.php';
?>