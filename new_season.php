<?php

include_once 'header.php';

global $pageUser;

if (!isset($pageUser)){
    header("Location: index.php");
} else if ($pageUser->getUserRole() !== 'admin' || $pageUser->getUserRole() !== 'adminCaptain' || $pageUser->getUserRole() !== 'adminPlaying'){
    header("Location: index.php");
}

//getting all of the admins
$params = null;
$params['fld'] = 'UserRole';
$params['val'] = 'admin';
$admins = new user();
$admins = $admins->FindAllByParams($params);

$params = null;
$params['fld'] = 'UserRole';
$params['val'] = 'adminPlaying';
$adminPlayers = new user();
$adminPlayers = $adminPlayers->FindAllByParams($params);

$allAdmins = array_merge($admins, $adminPlayers);

$params = null;
$params['fld'] = 'UserRole';
$params['val'] = 'adminCaptain';
$adminCaptains = new user();
$adminCaptains = $adminCaptains->FindAllByParams($params);

$allAdmins = array_merge($allAdmins, $adminCaptains);

$adminCount = count($allAdmins);

if (isset($_POST['season_name'])
    && isset($_POST['start_date'])
    && isset($_POST['end_date'])
    && isset($_POST['playoff_date'])
    && isset($_POST['info'])
    && isset($_POST['timestamp'])
    && isset($_POST['nickname'])
    && isset($_POST['phone'])
    && isset($_POST['email'])
    && isset($_POST['gender'])
    && isset($_POST['jersey'])
    && isset($_POST['dob'])
    && isset($_POST['absences'])
    && isset($_POST['playoffs'])
    && isset($_POST['buddy'])
    && isset($_POST['willingcaptain'])
    && isset($_POST['terms'])
    && isset($_POST['experience'])
    && isset($_POST['throwing'])
    && isset($_POST['cutting'])
    && isset($_POST['speed'])
    && isset($_POST['conditioning'])
    && isset($_POST['height'])
    && isset($_POST['comments'])
    ) {


    // remove all players, captains, teams, schedules
    $params = null;
    $params['fld'] = 'UserRole';
    $params['val'] = 'player';
    $removePlayers = new user();
    $removePlayers = $removePlayers->FindAllByParams($params);
    foreach($removePlayers as $player){
        $player->Delete($player);
    }

    $params = null;
    $params['fld'] = 'UserRole';
    $params['val'] = 'captain';
    $removeCaptains = new user();
    $removeCaptains = $removeCaptains->FindAllByParams($params);
    foreach ($removeCaptains as $captain) {
        $captain->Delete($captain);
    }

    $params = null;
    $params['fld'] = 'ID';
    $params['opp'] = '!=';
    $params['val'] = '';
    $removeTeams = new teams();
    $removeTeams = $removeTeams->FindAllByParams($params);
    foreach($removeTeams as $team){
        $team->Delete($team);
    }
    $params = null;
    $params['fld'] = 'ID';
    $params['opp'] = '!=';
    $params['val'] = '';
    $removeSchedule = new schedule();
    $removeSchedule = $removeSchedule->FindAllByParams($params);
    foreach($removeSchedule as $schedule){
        $schedule->Delete($schedule);
    }

    //set old season inactive
    $params = null;
    $params['fld'] = 'Active';
    $params['val'] = '1';
    $activeSeasons = new season();
    $activeSeasons = $activeSeasons->FindAllByParams($params);
    foreach ($activeSeasons as $season) {
        $season->setActive('0');
        $season->MakePersistant($season);
    }

    // create new season and make it active
    if (!empty($_POST['season_name']) && !empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['playoff_date']) && !empty($_POST['info'])) {
        $season = new season();
        $season->setName($_POST['season_name']);
        $season->setStartDate($_POST['start_date']);
        $season->setEndDate($_POST['end_date']);
        $season->setPlayoffDate($_POST['playoff_date']);
        $season->setInfo($_POST['info']);
        $season->setActive('1');
        $season->setDraftTurn('1');
        $season->MakePersistant($season);
    }


    // add new players
    if (isset($_POST['nickname'])){
        $playerCount = count($_POST['nickname']);
        for ($i = 0; $i < $playerCount; $i++){
            if (isset($_POST['timestamp'][$i])
                && isset($_POST['nickname'][$i])
                && isset($_POST['phone'][$i])
                && isset($_POST['email'][$i])
                && isset($_POST['gender'][$i])
                && isset($_POST['jersey'][$i])
                && isset($_POST['dob'][$i])
                && isset($_POST['absences'][$i])
                && isset($_POST['playoffs'][$i])
                && isset($_POST['willingcaptain'][$i])
                && isset($_POST['terms'][$i])
                && isset($_POST['experience'][$i])
                && isset($_POST['throwing'][$i])
                && isset($_POST['cutting'][$i])
                && isset($_POST['speed'][$i])
                && isset($_POST['conditioning'][$i])
                && isset($_POST['height'][$i])
            ) {
                $player = new user();
                $player->setTstamp($_POST['timestamp'][$i]);
                $player->setNickname($_POST['nickname'][$i]);
                $player->setPhone($_POST['phone'][$i]);
                $player->setEmail($_POST['email'][$i]);
                $player->setGender($_POST['gender'][$i]);
                $player->setJersey($_POST['jersey'][$i]);
                $player->setDOB($_POST['dob'][$i]);
                $player->setAbsence($_POST['absences'][$i]);
                $player->setPlayoffs($_POST['playoffs'][$i]);
                $player->setBuddy($_POST['buddy'][$i]);
                $player->setVerified($_POST['terms'][$i]);
                $player->setExperience($_POST['experience'][$i]);
                $player->setThrowing($_POST['throwing'][$i]);
                $player->setCutting($_POST['cutting'][$i]);
                $player->setSpeed($_POST['speed'][$i]);
                $player->setConditioning($_POST['conditioning'][$i]);
                $player->setHeight($_POST['height'][$i]);
                $player->setComments($_POST['comments'][$i]);
                $player->setPaid('0');

                $player->setDraftOrder('-1');

                if (isset($_POST['captain'][$i])) {
                    $player->setUserRole('captain');
                    $player->setPass('MUDACaptain!');
                } else {
                    $player->setUserRole('player');
                }

                $player->MakePersistant($player);
            }
        }
    }

    // update admin users (remove teamID, modify user role)
    if (isset($_POST['adminPlayingStatus'])) {
        foreach($allAdmins as $admin){
            $admin->setTeamID('');
            $admin->setDraftOrder('-1');
            if (isset($_POST['captain'][$admin->getID()])) {
                $admin->setUserRole('adminCaptain');
            } else if (isset($_POST['adminPlayingStatus'][$admin->getID()]) == 'playing') {
                if ($_POST['adminPlayingStatus'][$admin->getID()] == 'playing'){
                    $admin->setUserRole('adminPlaying');
                }
            } else {
                $admin->setUserRole('admin');
            }
            $admin->MakePersistant($admin);
        }
    }

    // create drafting order
    $params = null;
    $params['fld'] = 'UserRole';
    $params['val'] = 'captain';
    $captains = new user();
    $captains = $captains->FindAllByParams($params, 'rand()');

    $params = null;
    $params['fld'] = 'UserRole';
    $params['val'] = 'adminCaptain';
    $adminCaptains = new user();
    $adminCaptains = $adminCaptains->FindAllByParams($params, 'rand()');

    $allCaptains = array_merge($captains, $adminCaptains);

    $draftNum = count($allCaptains);

    foreach($allCaptains as $captain){
        $captain->setDraftOrder($draftNum);
        $captain->MakePersistant($captain);
        $draftNum--;
    }


    // create teams
    $params = null;
    $params['fld'] = 'UserRole';
    $params['val'] = 'adminCaptain';
    $admins = new user();
    $admins = $admins->FindAllByParams($params);

    $allCaptains = array_merge($captains, $admins);

    foreach ($allCaptains as $captain){
        $team = new teams();
        $team->setName($captain->getNickName() . "'s Team");
        $team->setCaptainID($captain->getID());
        $team->MakePersistant($team);
    }

    //add teamID to the captains
    $params = null;
    $params['fld'] = 'CaptainID';
    $params['opp'] = '!=';
    $params['val'] = '';
    $teams = new teams();
    $teams = $teams->FindAllByParams($params);

    foreach ($teams as $team) {
        $params = null;
        $params['fld'] = 'ID';
        $params['val'] = $team->getCaptainID();
        $captain = new user();
        $captain = $captain->FindByParams($params);

        $captain->setTeamID($team->getID());
        $captain->MakePersistant($captain);
    }

    // generate schedule



    header('Location: index.php?success=new_season_created');
    $_SESSION['success'] = '1';
    unset($_POST); $_POST = array();
} else {
    
}


?>

<script>

    let potentialCaptains = [];

    $(function () {

        $('form').bind("keypress", function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                //isStep2Done();
                return false;
            }
        });

        //player uploader
        $("#upload").bind("click", function () {
        // $("#fileUpload").change(function () {
            console.log("hit");
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
                                    + '<th>Experience</th>'
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
                                        var cell;
                                        var input;
                                        switch(j){
                                            case 0:
                                                cell = $("<td />");
                                                input = $("<input name='timestamp[]' onchange='checkLength($(this), " + i + ", 32);' maxlength='32'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '32'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 1:
                                                cell = $("<td />");
                                                input = $("<input id='" + i + "' name='nickname[]' onchange='checkLength($(this), " + i + ", 45);' maxlength='45'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '45'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 2:
                                                cell = $("<td />");
                                                input = $("<input name='phone[]' onchange='checkLength($(this), " + i + ", 45);; 'maxlength='45'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '45'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 3:
                                                cell = $("<td />");
                                                input = $("<input name='email[]' onchange='checkLength($(this), " + i + ", 45);' maxlength='45'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '45'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 4:
                                                cell = $("<td />");
                                                input = $("<input name='gender[]' onchange='checkLength($(this), " + i + ", 45);' maxlength='45'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '45'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 5:
                                                cell = $("<td />");
                                                input = $("<input name='jersey[]' onchange='checkLength($(this), " + i + ", 45);' maxlength='45'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '45'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 6:
                                                cell = $("<td />");
                                                input = $("<input name='dob[]' onchange='checkLength($(this), " + i + ", 45);' maxlength='45'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '45'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 7:
                                                cell = $("<td />");
                                                input = $("<input name='absences[]' onchange='checkLength($(this), " + i + ", 3);' maxlength='3'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '3'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 8:
                                                cell = $("<td />");
                                                input = $("<input name='playoffs[]' onchange='checkLength($(this), " + i + ", 45);' maxlength='45'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '45'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 9:
                                                cell = $("<td />");
                                                input = $("<input name='buddy[]' onchange='checkLength($(this), " + i + ", 45);' maxlength='45'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '45'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 10:
                                                cell = $("<td />");
                                                input = $("<input name='willingcaptain[]' onchange='checkLength($(this), " + i + ", 30);' maxlength='30'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '30'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 11:
                                                cell = $("<td />");
                                                input = $("<input name='terms[]' onchange='checkLength($(this), " + i + ", 45);' maxlength='45'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '45'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 12:
                                                cell = $("<td />");
                                                input = $("<input name='experience[]' onchange='checkLength($(this), " + i + ", 1);' maxlength='1'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '1'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 13:
                                                cell = $("<td />");
                                                input = $("<input name='throwing[]' onchange='checkLength($(this), " + i + ", 1);' maxlength='1'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '1'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 14:
                                                cell = $("<td />");
                                                input = $("<input name='cutting[]' onchange='checkLength($(this), " + i + ", 1);' maxlength='1'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '1'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 15:
                                                cell = $("<td />");
                                                input = $("<input name='speed[]' onchange='checkLength($(this), " + i + ", 1);' maxlength='1'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '1'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 16:
                                                cell = $("<td />");
                                                input = $("<input name='conditioning[]' onchange='checkLength($(this), " + i + ", 1);' maxlength='1'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '1'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 17:
                                                cell = $("<td />");
                                                input = $("<input name='height[]' onchange='checkLength($(this), " + i + ", 10);' maxlength='10'/>").val(cells[j]);
                                                input.appendTo(cell);
                                                if(cells[j].length > '10'){
                                                    cell.addClass('error');
                                                }
                                                cell.append();
                                                break;
                                            case 18:
                                                cell = $("<td />");
                                                input = $("<input name='comments[]' />").val(cells[j]);
                                                input.appendTo(cell);
                                                cell.append();
                                                break;
                                            default:
                                                cell = $("<td />");
                                                cell.append(cells[j]);
                                                break;

                                        }

                                        row.append(cell);
                                        if (j == 10) {
                                            if(cells[j] == 'Yes'){
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
                        $('#numErrors').css('display', 'flex');
                        $('#numOfErrors').html($(".error").length);
                    }
                    reader.readAsText($("#fileUpload")[0].files[0]);
                    $('#fileUploader').hide();
                    setTimeout(function() {
                        isStep2Done();
                        $('.captain [name="nickname[]"]').each(function(){
                            potentialCaptains.push([$(this).val(), $(this).attr('id')]);
                        });
                    }, 1000);
                    areSteps123Done();
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid CSV file.");
            }
        });
    });

    function checkLength(elem, id, maxLength) {
        if (elem.val().length <= maxLength){
            elem.parent().removeClass('error');
        }
        $('#numOfErrors').html($(".error").length);
        isStep2Done();
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
                potentialCaptains.push([name, id]);
            }
        });
        isStep3Done();
    }

    function isStep2Done(){
        if ($('.error').length == '0'){
            $('#step2icon').css('background', '#00b2a9');
            $('#numErrors').slideUp();
        }
        areSteps123Done();
    }

    function isStep3Done(){
        let checkedNum = $('input[value="notPlaying"]:checked').length + $('input[value="playing"]:checked').length;
        if (checkedNum == '<?php echo $adminCount; ?>'){
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
        $('#step4 tbody').html('');
        for (var i = 0; i < potentialCaptains.length; i++){
            let tr = '<tr style="padding: 20px;">'
                + '<td>' + potentialCaptains[i][0] + '</td>'
                + '<td><div class="form-check" style="text-align:center;">'
                + '<input name="captain[' + potentialCaptains[i][1] +']" onchange="teamCount();" class="form-check-input position-static" style="width: 20px; height: 20px;" type="checkbox" value="captain" aria-label="...">'
                + '</div></td>'
            $('#step4 tbody').append(tr);
        }
    }

    function teamCount(){
        let num = $('input[value="captain"]:checked').length;
        $('#numOfTeams').html(num);
        isStep4Done();
    }

    function isStep4Done(){
        if($('#numOfTeams').html() >= '2' ){
            $('#step4icon').css('background', '#00b2a9');
        } else {
            $('#step4icon').css('background', '');
        }
        showSubmitButton();
    }

    function showSubmitButton(){
        if($('#step1icon').css('background') == 'rgb(0, 178, 169) none repeat scroll 0% 0% / auto padding-box border-box'
        && $('#step2icon').css('background') == 'rgb(0, 178, 169) none repeat scroll 0% 0% / auto padding-box border-box'
        && $('#step3icon').css('background') == 'rgb(0, 178, 169) none repeat scroll 0% 0% / auto padding-box border-box'
        && $('#step4icon').css('background') == 'rgb(0, 178, 169) none repeat scroll 0% 0% / auto padding-box border-box') {
            $('#submitButton').show();
        }
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

    .error{
        background-color: red;
    }
    /*  test  */
    /*.drop-container {*/
    /*    position: relative;*/
    /*    display: flex;*/
    /*    gap: 10px;*/
    /*    flex-direction: column;*/
    /*    justify-content: center;*/
    /*    align-items: center;*/
    /*    height: 200px;*/
    /*    padding: 20px;*/
    /*    border-radius: 10px;*/
    /*    border: 2px dashed #555;*/
    /*    color: #444;*/
    /*    cursor: pointer;*/
    /*    transition: background .2s ease-in-out, border .2s ease-in-out;*/
    /*}*/

    /*.drop-container:hover {*/
    /*    background: #eee;*/
    /*    border-color: #111;*/
    /*}*/

    /*.drop-container:hover .drop-title {*/
    /*    color: #222;*/
    /*}*/

    /*.drop-title {*/
    /*    color: #444;*/
    /*    font-size: 20px;*/
    /*    font-weight: bold;*/
    /*    text-align: center;*/
    /*    transition: color .2s ease-in-out;*/
    /*}*/

    input[type=file] {
        width: 350px;
        max-width: 100%;
        color: #444;
        padding: 5px;
        background: #fff;
        border-radius: 10px;
        border: 1px solid #555;
    }

    input[type=file]::file-selector-button {
        margin-right: 20px;
        border: none;
        background: #00b2a9;
        border: 3px solid #0c2340;
        padding: 10px 20px;
        border-radius: 10px;
        color: #fff;
        cursor: pointer;
        transition: background .2s ease-in-out;
    }

    input[type=file]::file-selector-button:hover {
        background: #0c2340;
    }
    /*  test  */

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
<!--            <input type="file" id="fileUpload">-->
<!--            <input type="button" id="upload" value="Upload">-->
<!--            <label id="dropZone" class="drop-container">-->
<!--                <span class="drop-title">Drop CSV file here</span>-->
<!--                or-->
                <input type="file" id="fileUpload">
                <input class="btn btn-secondary" type="button" id="upload" value="Upload">
<!--            </label>-->
        </div>


        <div id="numErrors" class="alert alert-danger" style="display:none; flex-direction: column; align-items: center; margin-bottom: 20px; width: 60%; left: 0; right: 0; margin-left: auto; margin-right: auto;">
            <div style="display:flex;">
                <h4 style="">Errors Found: </h4>
                <h4 id="numOfErrors" style="padding-left: 10px;"></h4>
            </div>
            <div>
                <p style="text-align:center;">One or more of your fields are too long, please find the field with a red background and shorten the text.</p>
            </div>
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
            foreach($allAdmins as $admin) {
                $rows .= '<tr style="padding: 20px;">'
                    . '<td>' . $admin->getNickname() . '</td>'
                    . '<td><div class="form-check" style="text-align:center;">'
                    . '<input id="' . $admin->getID() . '" class="form-check-input position-static" onchange="uncheckCheckbox($(this), \'' . $admin->getID() . '\');" style="width: 20px; height: 20px;" type="checkbox" name="adminPlayingStatus[' . $admin->getID() . ']" value="notPlaying" aria-label="...">'
                    . '</div></td>'
                    . '<td><div class="form-check" style="text-align:center;">'
                    . '<input id="' . $admin->getID() . '" class="form-check-input position-static" onchange="uncheckCheckbox($(this), \'' . $admin->getID() . '\', \'' . $admin->getNickName() . '\');" style="width: 20px; height: 20px;" type="checkbox" name="adminPlayingStatus[' . $admin->getID() . ']" value="playing" aria-label="...">'
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
            <h4 style="display:flex; justify-content: center;">Number of Teams =  <div id="numOfTeams" style="padding-left: 10px;">0</div></h4>
        </div>
    </div>

    <button id="submitButton" type="submit" class="btn btn-secondary" style="display: none; margin: 50px;position: relative;left: 25%;width: 40%;padding: 30px; font-size: 24px;">Create Season</button>
</form>

<?php include_once 'footer.php'; ?>
