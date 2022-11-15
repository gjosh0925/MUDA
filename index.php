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
