<?php

include_once 'header.php';


?>

<script>
    $(function(){
        getDraftablePlayers();
    });


    function getDraftablePlayers(){
        var datapacket = {
            TODO: 'draftPlayers'
        };
        $.ajax({
            type:"POST",
            // url:"http://localhost//MUDA/www_home/includes/async.php",
            url: SiteURL,
            data:datapacket,
            dataType:"json",
            // crossDomain: true,
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
</script>

<style>
    div {
        border: 2px solid black;
    }
</style>



<h1 style="text-align:center;">The Draft</h1>
<div style="display: flex; flex-direction: row; flex-wrap: wrap; align-items:flex-start;">
    <div id="players" style="width: 69%; height:80vh; overflow:auto; padding: .5%; margin:.5%;">
        <h3>Draftable Players</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">NickName</th>
                    <th scope="col">Throwing</th>
                    <th scope="col">Cutting</th>
                    <th scope="col">Speed</th>
                    <th scope="col">Conditioning</th>
                    <th scope="col">Experience</th>
                    <th scope="col">Buddy</th>
                    <th scope="col">Height</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Playoffs</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Josh Glaser</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>Emily Burnett</td>
                    <td>5'11</td>
                    <td>Male</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>Josh Glaser</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>Emily Burnett</td>
                    <td>5'11</td>
                    <td>Male</td>
                    <td>Yes</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="yourTeam" style="width: 29%; height: 80vh; padding: .5%; margin:.5%;">
        <h3>Team <?php ?></h3>
    </div>

    <div id="otherTeams" style="width: 69%; height: 20vh; padding: .5%; margin:.5%;">

    </div>

    <div id="stats" style="width: 29%; height: 20vh; padding: .5%; margin:.5%;">

    </div>
</div>