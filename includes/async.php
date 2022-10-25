<?php

include_once 'includes.php';

global $conn;
switch ($_POST['TODO']) {
    case 'draftPlayers':
        return draftPlayers();
    case 'populateSchedule':
        return populateSchedule();
    case 'userPaidStatus':
        return userPaidStatus();
    case 'submitDraftOrder':
        return submitDraftOrder();
    case 'submitSeasonInfo':
        return submitSeasonInfo();
    default:
        echo "Function does not exist.\n";
        break;
}

function draftPlayers(){
    try {

        $params = null;
        $params['fld'] = 'DraftOrder';
        $params['opp'] = '!=';
        $params['val'] = '-1';
        $captains = new user();
        $captains = $captains->FindAllByParams($params, "DraftOrder");

        $draftOrder = array();
        foreach($captains as $captain){
            $draftOrder[] = $captain->getNickName();
        }

        $params = null;
        $params['fld'] = 'Active';
        $params['val'] = '1';
        $season = new season();
        $season = $season->FindByParams($params);

        if ($_POST['pickedPlayer'] != ''){
            error_log($_POST['TeamID']);
            $pickedPlayer = new user($_POST['pickedPlayer']);
            error_log(print_r($pickedPlayer, true));
            $pickedPlayer->setTeamID($_POST['TeamID']);
            $pickedPlayer->MakePersistant($pickedPlayer);
            error_log(print_r($pickedPlayer, true));
        }

        //select all available players
        $params = null;
        $params['fld'] = 'TeamID';
        $params['val'] = '';
        $availablePlayers = new user();
        $availablePlayers = $availablePlayers->FindAllByParams($params); //ID limit 134

        //select all picked players
        $params = null;
        $params['fld'] = 'TeamID';
        $params['opp'] = '!=';
        $params['val'] = '';
        $pickedPlayers = new user();
        $pickedPlayers = $pickedPlayers->FindAllByParams($params);

        $reply['availablePlayers'] = $availablePlayers;
        $reply['pickedPlayers'] = $pickedPlayers;
        $reply['draftOrder'] = $draftOrder;
        $reply['draftOrderCount'] = count($draftOrder);
        $reply['draftTurn'] = $season->getDraftTurn();

//        error_log(utf8_encode(json_encode($reply, JSON_FORCE_OBJECT)));
        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }

}

function populateSchedule(){
    try {

        $params = null;
        $params['fld'] = 'ID';
        $params['opp'] = '!=';
        $params['val'] = '';
        $schedules = new schedule();
        $schedules = $schedules->FindAllByParams($params);

        $teamOne = array();
        $teamTwo = array();
        foreach($schedules as $schedule){
            $one = new teams($schedule->getTeamOneID());
            $two = new teams($schedule->getTeamTwoID());

            $teamOne[] = $one->getName();
            $teamTwo[] = $two->getName();
        }


        $reply['schedules'] = $schedules;
        $reply['teamOneName'] = $teamOne;
        $reply['teamTwoName'] = $teamTwo;

        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }
}

function userPaidStatus(){
    try {
        $user = new user($_POST['UserID']);
        $user->setPaid($_POST['Paid']);
        $user = $user->MakePersistant($user);

        $reply['success'] = true;
        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }
}

function submitDraftOrder(){
    try {
        $draftOrder = $_POST['NewOrder'];
        $num = 1;
        foreach ($draftOrder as $id){
            $captain = new user($id);
            $captain->setDraftOrder($num);
            $captain->MakePersistant($captain);
            $num++;
        }

        $reply['success'] = true;
        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }
}

function submitSeasonInfo(){
    try {
        $season = new season($_POST['SeasonID']);

        $season->setName($_POST['Name']);
        $season->setStartDate($_POST['StartDate']);
        $season->setEndDate($_POST['EndDate']);
        $season->setPlayoffDate($_POST['PlayoffDate']);
        $season->setInfo($_POST['Info']);
        $season->MakePersistant($season);

        $reply['success'] = true;
        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }
}
