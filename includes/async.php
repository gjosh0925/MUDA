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
    case 'getAverageStats':
        return getAverageStats();
    case 'generateSchedule':
        return generateSchedule();
    case 'addGameToSchedule':
        return addGameToSchedule();
    default:
        echo "Function does not exist.\n";
        break;
}

function draftPlayers(){
    try {

        $params = null;
        $params['fld'] = 'Active';
        $params['val'] = '1';
        $season = new season();
        $season = $season->FindByParams($params);

        $params = null;
        $params['fld'] = 'DraftOrder';
        $params['opp'] = '!=';
        $params['val'] = '-1';
        $draftOrder = new user();
        $draftOrder = $draftOrder->FindAllByParams($params, 'DraftOrder');

        if ($_POST['pickedPlayer'] != ''){
            //if player was picked, assign player to that team and then change draft order by one
            $pickedPlayer = new user($_POST['pickedPlayer']);
            $pickedPlayer->setTeamID($_POST['TeamID']);
            $pickedPlayer->MakePersistant($pickedPlayer);

            if ($season->getDraftTurn() == count($draftOrder)) {
                //if all captains have picked a player, we need to switch the captains order
                $params = null;
                $params['fld'] = 'DraftOrder';
                $params['opp'] = '!=';
                $params['val'] = '-1';
                $draftOrder = new user();
                $draftOrder = $draftOrder->FindAllByParams($params, 'DraftOrder');

                $capNum = count($draftOrder);

                foreach($draftOrder as $captain) {
                    $captain->setDraftOrder($capNum);
                    $captain->MakePersistant($captain);
                    $capNum--;
                }

                $season->setDraftTurn('1');
                $season->MakePersistant($season);
            } else {
                $turn = ($season->getDraftTurn() + 1);
                $season->setDraftTurn($turn);
                $season->MakePersistant($season);

            }
        }

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

        //select all available players
        $params = null;
        $params['fld'] = 'TeamID';
        $params['val'] = '';
        $availablePlayers = new user();
        $availablePlayers = $availablePlayers->FindAllByParams($params); //ID limit 134

        $availPlayers = array();
        foreach($availablePlayers as $player) {
            $availPlayer = array();
            $availPlayer['id'] = $player->getID();
            $availPlayer['name'] = $player->getNickname();
            $availPlayer['throwing'] = $player->getThrowing();
            $availPlayer['cutting'] = $player->getCutting();
            $availPlayer['speed'] = $player->getSpeed();
            $availPlayer['conditioning'] = $player->getConditioning();
            $availPlayer['experience'] = $player->getExperience();
            $availPlayer['buddy'] = $player->getBuddy();
            $availPlayer['height'] = $player->getHeight();
            $availPlayer['gender'] = $player->getGender();
            $availPlayer['absence'] = $player->getAbsence();
            $availPlayer['playoffs'] = $player->getPlayoffs();

            $availPlayers[] = $availPlayer;
        }

        //select all picked players
        $params = null;
        $params['fld'] = 'TeamID';
        $params['opp'] = '!=';
        $params['val'] = '';
        $pickedPlayers = new user();
        $pickedPlayers = $pickedPlayers->FindAllByParams($params);

        $pickPlayers = array();
        foreach($pickedPlayers as $player) {
            $pickPlayer = array();

            $pickPlayer['id'] = $player->getID();
            $pickPlayer['name'] = $player->getNickname();
            $pickPlayer['throwing'] = $player->getThrowing();
            $pickPlayer['cutting'] = $player->getCutting();
            $pickPlayer['speed'] = $player->getSpeed();
            $pickPlayer['conditioning'] = $player->getConditioning();
            $pickPlayer['experience'] = $player->getExperience();
            $pickPlayer['buddy'] = $player->getBuddy();
            $pickPlayer['height'] = $player->getHeight();
            $pickPlayer['gender'] = $player->getGender();
            $pickPlayer['absence'] = $player->getAbsence();
            $pickPlayer['playoffs'] = $player->getPlayoffs();
            $pickPlayer['teamid'] = $player->getTeamID();

            $pickPlayers[] = $pickPlayer;
        }


        $reply['availablePlayers'] = $availPlayers;
        $reply['pickedPlayers'] = $pickPlayers;
        $reply['draftOrder'] = $draftOrder;
        $reply['draftOrderCount'] = count($draftOrder);
        $reply['draftTurn'] = $season->getDraftTurn();

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

function getAverageStats(){
    try{

        $params = null;
        $params['fld'] = 'ID';
        $params['opp'] = '!=';
        $params['val'] = '';
        $teams = new teams();
        $teams = $teams->FindAllByParams($params);

        $averageStats = array();
        foreach($teams as $team){
            $stat = array();

            $stat['teamName'] = $team->getName();

            $params = null;
            $params['fld'] = 'TeamID';
            $params['val'] = $team->getID();
            $players = new user();
            $players = $players->FindAllByParams($params);

            $totalThrowing = 0;
            foreach($players as $player) {
                $totalThrowing += $player->getThrowing();
            }
            $stat['throwing'] = $totalThrowing / count($players);

            $totalCutting = 0;
            foreach($players as $player) {
                $totalCutting += $player->getCutting();
            }
            $stat['cutting'] = $totalCutting / count($players);

            $totalSpeed = 0;
            foreach($players as $player) {
                $totalSpeed += $player->getSpeed();
            }
            $stat['speed'] = $totalSpeed / count($players);

            $totalConditioning = 0;
            foreach($players as $player) {
                $totalConditioning += $player->getConditioning();
            }
            $stat['conditioning'] = $totalConditioning / count($players);

            $totalExperience = 0;
            foreach($players as $player) {
                $totalExperience += $player->getExperience();
            }
            $stat['experience'] = $totalExperience / count($players);

            $averageStats[] = $stat;
        }

        $reply['averageStats'] = $averageStats;
        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }

}

function generateSchedule(){
    try{

        $season = new season($_POST['SeasonID']);

        $params = null;
        $params['fld'] = 'ID';
        $params['opp'] = '!=';
        $params['val'] = '';
        $teams = new teams();
        $teams = $teams->FindAllByParams($params);

        $start = date_create($season->getStartDate());
        $end = date_create($season->getEndDate());
        $totalDays = date_diff($start, $end);
        echo $totalDays->format("%R%a days");

        $dow = $_POST['Days']; //days a week in array form
        $numFields = $_POST['Fields'];
        $gad = 2; //games a day
        $numTeams = count($teams);

        $reply = '';
        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }
}

function addGameToSchedule(){
    try{

        $schedule = new schedule;
        $schedule->setTeamOneID($_POST['TeamOne']);
        $schedule->setTeamTwoID($_POST['TeamTwo']);
        $schedule->setDate($_POST['Date'] . ' ' . $_POST['Time']);
        $schedule->setField($_POST['Field']);
        $schedule->setTeamOneScore('-1');
        $schedule->setTeamTwoScore('-1');
        $schedule->MakePersistant($schedule);

        $reply['success'] = true;
        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }
}
