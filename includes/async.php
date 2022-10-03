<?php

include_once 'includes.php';

global $conn;
switch ($_POST['TODO']) {
    case 'draftPlayers':
        return draftPlayers();
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

        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }

}
