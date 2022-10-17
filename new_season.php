<?php

include_once 'header.php';

//getting all of the admins
$params = null;
$params['fld'] = 'UserRole';
$params['val'] = 'admin';
$params['val2'] = 'adminPlayer';
$admins = new user();
$admins = $admins->FindAllByParams($params);

if (isset($_POST['season_name'])) {
    if ($_POST['season_name'] !== '' && $_POST['start_date'] !== '' && $_POST['end_date'] !== '' && $_POST['playoff_date'] !== '' && $_POST['info'] !== '') {
        $season = new season();
        $season->setName($_POST['season_name']);
        $season->setStartDate($_POST['start_date']);
        $season->setEndDate($_POST['end_date']);
        $season->setPlayoffDate($_POST['playoff_date']);
        $season->setInfo($_POST['info']);
        //$season->MakePersistant($season);
    }
}

//submit button needs to
// - remove all players, captains, teams, schedules
// - create new season and make it active
// - add new players
// - update admin users (remove teamID, modify user role)
// - generate schedule
// - create drafting order


?>

<script>

    let potentialCaptains = [];

    $(function () {
        //player uploader
        $("#upload").bind("click", function () {
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
            if (regex.test($("#fileUpload").val().toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var table = $("<table id='allPlayersTable' class='table' />");
                        var rows = e.target.result.split("\n");
                        for (var i = 0; i < rows.length; i++) {
                            if (i == 0) {
                                var row = '<thead style="position: sticky; top: 0px;">'
                                    + '<tr>'
                                    + '<th>TimeStamp</th>'
                                    + '<th>Name</th>'
                                    + '<th>Phone Number</th>'
                                    + '<th>Email</th>'
                                    + '<th>Gender</th>'
                                    + '<th>Jersey</th>'
                                    + '<th>DOB</th>'
                                    + '<th>Absenses</th>'
                                    + '<th>Attending Playoffs</th>'
                                    + '<th>Buddy</th>'
                                    + '<th>Captain</th>'
                                    + '<th>Terms</th>'
                                    + '<th>TimeStamp</th>'
                                    + '<th>Throwing</th>'
                                    + '<th>Cutting</th>'
                                    + '<th>Speed</th>'
                                    + '<th>Conditioning</th>'
                                    + '<th>Height</th>'
                                    + '<th>Comments</th>'
                                    + '</tr>'
                                    + '</thead>';
                                table.append(row);
                            } else {
                                var row = $("<tr />");
                                var cells = rows[i].split(",");
                                if (cells.length > 1) {
                                    for (var j = 0; j < cells.length; j++) {
                                        var cell = $("<td />");
                                        cell.html(cells[j]);
                                        row.append(cell);
                                        if (j == 10) {
                                            if(cell.html() == 'Yes'){
                                                row.addClass('captain');
                                            }
                                        }
                                    }
                                    table.append(row);
                                }
                            }
                        }
                        $("#dvCSV").html('');
                        $("#dvCSV").append(table);
                    }
                    reader.readAsText($("#fileUpload")[0].files[0]);
                    $('#fileUploader').hide();
                    $('#step2icon').css('background', '#00b2a9');
                    setTimeout(function() {
                        $('.captain td:nth-child(2)').each(function(){
                            potentialCaptains.push($(this).html());
                        });
                    }, 3000);
                    areSteps123Done();
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid CSV file.");
            }
        });
    });

    function populateCaptains(){
        console.log("Running");
        $('.captain').each(function(){
            console.log('hit');
        });
    }

    function isStep1Done(){
        if ($('[name="season_name"]').val() !== '' && $('[name="start_date"]').val() !== '' && $('[name="end_date"]').val() !== '' && $('[name="playoff_date"]').val() !== '' && $('[name="info"]').val() !== '') {
            $('#step1icon').css('background', '#00b2a9');
        } else {
            $('#step1icon').css('background', '');
        }
        areSteps123Done();
    }

    function uncheckCheckbox(checked, id, name = ''){
        $("input[id$='" + id + "']").each(function() {
            if (!checked.is(this)) {
                $(this).prop('checked', false);
            } else if (name != ''){
                console.log(name);
                potentialCaptains.push(name);
            }
        });
        isStep3Done();
    }

    function isStep3Done(){
        let checkedNum = $('input[name="adminPlayingStatus"]:checked').length;
        if (checkedNum == '<?php echo count($admins); ?>'){
            $('#step3icon').css('background', '#00b2a9');
        } else {
            $('#step3icon').css('background', '');
        }
        areSteps123Done();
    }

    function areSteps123Done(){
        if ($('#step1icon').css('background') == 'rgb(0, 178, 169) none repeat scroll 0% 0% / auto padding-box border-box' && $('#step2icon').css('background') == 'rgb(0, 178, 169) none repeat scroll 0% 0% / auto padding-box border-box' && $('#step3icon').css('background') == 'rgb(0, 178, 169) none repeat scroll 0% 0% / auto padding-box border-box') {
            populateStep4();
        }
    }

    function populateStep4(){
        $('#step4text').hide();
        $('#captainsDiv').show();
        for (var i = 0; i < potentialCaptains.length; i++){
            let tr = '<tr style="padding: 20px;">'
                + '<td>' + potentialCaptains[i] + '</td>'
                + '<td><div class="form-check" style="text-align:center;">'
                + '<input onchange="teamCount();" class="form-check-input position-static" style="width: 20px; height: 20px;" type="checkbox" name="teamCaptains" value="captain" aria-label="...">'
                + '</div></td>'
            $('#step4 tbody').append(tr);
        }
    }

    function teamCount(){
        let num = $('input[name="teamCaptains"]:checked').length;
        $('#numOfTeams').html(num);
    }

</script>

<style>
    .step{
        margin: 20px 100px 40px 100px;
        border: 3px solid #0c2340;
        border-radius: 5px;
        padding: 30px;
    }

    h3{
        margin: 50px 0px 0px 110px;
    }

    .progressSteps{
        position:relative;
        left:35%;
        padding-bottom: 80px;
    }

    .check{
        position: relative;
        top: 45px;
        right: 45px;
    }

    .uploadedPlayers {
        overflow: auto;
        max-height: 800px;
    }

    #allPlayersTable td, tr {
        border: 2px solid #0c2340;
    }

    #allPlayersTable th {
        background-color: #00b2a9;
        color: #0c2340;
        cursor: pointer;
        border-bottom: 3px solid #0c2340 !important;
    }

    #allPlayersTable table {
        border: 3px solid #0c2340 !important;
    }

    #leagCoodTable td{
        padding: 10px;
    }

    #captainsTable td{
        padding: 10px;
    }
</style>

<div id="progressDiv" style="background: #0c2340; width: 20%; color: white; position:fixed; top: 0; height: 100%; z-index: -1;padding-top:50px;">
    <div class="progressSteps" style="padding-top: 25%;">
        <i id="step1icon" class="fa-2x fa-regular fa-circle-check check" style="border-radius: 100%;"></i><h1>Step 1</h1>
    </div>
    <div class="progressSteps">
        <i id="step2icon" class="fa-2x fa-regular fa-circle-check check" style="border-radius: 100%;"></i><h1>Step 2</h1>
    </div>
    <div class="progressSteps">
        <i id="step3icon" class="fa-2x fa-regular fa-circle-check check" style="border-radius: 100%;"></i><h1>Step 3</h1>
    </div>
    <div class="progressSteps">
        <i id="step4icon" class="fa-2x fa-regular fa-circle-check check" style="border-radius: 100%;"></i><h1>Step 4</h1>
    </div>
</div>

<form id='seasonForm' action="new_season.php" method="post" style="position: absolute; width:80%; left: 20%;">
    <h1 style="text-align:center;">Create New Season</h1>
    <h3>Step 1: Season Info</h3>
    <div id="step1" class="step">
        <label>Season Name</label>
        <input class="form-control" type="text" name="season_name" onchange="isStep1Done();"><br>
        <div style="display:flex; justify-content: space-between; flex-wrap: wrap;">
            <div style="display:flex; flex-direction: column">
                <label>Start Date</label>
                <input class="form-control" type="date" name="start_date" onchange="isStep1Done();"><br>
            </div>
            <div style="display:flex; flex-direction: column">
                <label>End Date</label>
                <input class="form-control" type="date" name="end_date" onchange="isStep1Done();"><br>
            </div>
            <div style="display:flex; flex-direction: column">
                <label>Playoff Date</label>
                <input class="form-control" type="date" name="playoff_date" onchange="isStep1Done();"><br>
            </div>
        </div>
        <label>Season Info</label>
        <textarea class="form-control" id="" name="info" onchange="isStep1Done();"></textarea>
    </div>

    <h3>Step 2: Upload Players</h3>
    <div id="step2" class="step">
        <div id="fileUploader">
            <input type="file" id="fileUpload">
            <input type="button" id="upload" value="Upload">
        </div>
        <div id="dvCSV" class="uploadedPlayers">
        </div>
    </div>

    <h3>Step 3: Choose League Coordinators playing this season</h3>
    <div id="step3" class="step">
        <table style="width:100%; border-collapse: inherit;" id="leagCoodTable">
            <thead>
                <tr>
                    <th style="padding-left: 10px;">Name</th>
                    <th style="text-align: center;">Not Playing</th>
                    <th style="text-align: center;">Playing</th>
                </tr>
            </thead>
            <?php
            $rows = '';
            foreach($admins as $admin) {
                $rows .= '<tr style="padding: 20px;">'
                       . '<td>' . $admin->getNickname() . '</td>'
                       . '<td><div class="form-check" style="text-align:center;">'
                       . '<input id="' . $admin->getID() . '" class="form-check-input position-static" onchange="uncheckCheckbox($(this), \'' . $admin->getID() . '\');" style="width: 20px; height: 20px;" type="checkbox" name="adminPlayingStatus" value="notPlaying" aria-label="...">'
                       . '</div></td>'
                       . '<td><div class="form-check" style="text-align:center;">'
                       . '<input id="' . $admin->getID() . '" class="form-check-input position-static" onchange="uncheckCheckbox($(this), \'' . $admin->getID() . '\', \'' . $admin->getNickName() . '\');" style="width: 20px; height: 20px;" type="checkbox" name="adminPlayingStatus" value="playing" aria-label="...">'
                       . '</div></td>'
                       . '</tr>';
            }
            echo $rows;
            ?>
        </table>
    </div>

    <h3>Step 4: Choose Captains</h3>
    <div id="step4" class="step">
        <p id="step4text">Please complete all above steps first</p>
        <div id="captainsDiv" style="display:none;">
            <table id="captainsTable" style="width:100%; border-collapse: inherit;">
                <thead>
                <th>Name</th>
                <th style="text-align:center;">Captain</th>
                </thead>
                <tbody>

                </tbody>
            </table>
            <h4 style="display:flex; justify-content: center;">Number of Teams =  <div id="numOfTeams">0</div></h4>
        </div>
    </div>

    <button type="submit" class="btn btn-secondary" style="    margin: 50px;position: relative;left: 25%;width: 40%;padding: 30px; font-size: 24px;">Create Season</button>
</form>

<?php include_once 'footer.php'; ?>
