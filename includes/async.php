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
    default:
        echo "Function does not exist.\n";
        break;
}

function draftPlayers(){
    try {

        if ($_POST['pickedPlayer'] != ''){
            $pickedPlayer = new user($_POST['pickedPlayer']);
            $pickedPlayer->setTeamID($_POST['TeamID']);
            $pickedPlayer->MakePersistant($pickedPlayer);
        }

        //select all available players
        $params = null;
        $params['fld'] = 'TeamID';
        $params['val'] = '';
        $availablePlayers = new user();
        $availablePlayers = $availablePlayers->FindAllByParams($params);
        $reply['availablePlayers'] = $availablePlayers;

        //select all picked players
        $params = null;
        $params['fld'] = 'TeamID';
        $params['opp'] = '!=';
        $params['val'] = '';
        $pickedPlayers = new user();
        $pickedPlayers = $pickedPlayers->FindAllByParams($params);
        $reply['pickedPlayers'] = $pickedPlayers;

        //error_log(utf8_encode(json_encode($reply, JSON_FORCE_OBJECT)));

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

        //echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
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
