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
    case 'getUserInfo':
        return getUserInfo();
    case 'updateUserInfo':
        return updateUserInfo();
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
        $schedules = $schedules->FindAllByParams($params, 'Date, Field');

        $theSchedule = array();
        foreach($schedules as $schedule){
            $sched = array();
            $teamOne = new teams($schedule->getTeamOneID());
            $teamTwo = new teams($schedule->getTeamTwoID());

            $score = '';
            if ($schedule->getTeamOneScore() !== '-1' && $schedule->getTeamTwoScore() !== '-1'){
                $score = $schedule->getTeamOneScore() . '-' . $schedule->getTeamTwoScore();
            }

            $sched['Date'] = date('n/j/Y g:ia',strtotime($schedule->getDate()));
            $sched['Field'] = $schedule->getField();
            $sched['TeamOne'] = $teamOne->getName();
            $sched['TeamTwo'] = $teamTwo->getName();
            $sched['Score'] = $score;

            $theSchedule[] = $sched;
        }

        $reply['schedules'] = $theSchedule;
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

function getUserInfo(){
    try{

        $user = new user($_POST['UserID']);

        $info = array();
        $info['UserID'] = $user->getID();
        $info['Nickname'] = $user->getNickname();
        $info['Email'] = $user->getEmail();
        $info['Phone'] = $user->getPhone();
        $info['Gender'] = $user->getGender();
        $info['DOB'] = $user->getDOB();
        $info['UserRole'] = $user->getUserRole();
        $info['Jersey'] = $user->getJersey();
        $info['Absences'] = $user->getAbsence();
        $info['Playoffs'] = $user->getPlayoffs();
        $info['Buddy'] = $user->getBuddy();
        $info['Throwing'] = $user->getThrowing();
        $info['Cutting'] = $user->getCutting();
        $info['Speed'] = $user->getSpeed();
        $info['Conditioning'] = $user->getConditioning();
        $info['Experience'] = $user->getExperience();
        $info['Height'] = $user->getHeight();
        $info['Comment'] = $user->getComments();


        $reply['userInfo'] = $info;
        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }
}

function updateUserInfo(){
    try{
        $user = new user($_POST['UserID']);

        $user->setNickname($_POST['Nickname']);
        $user->setEmail($_POST['Email']);
        $user->setPhone($_POST['Phone']);
        $user->setGender($_POST['Gender']);
        $user->setDOB($_POST['DOB']);
        $user->setUserRole($_POST['UserRole']);
        $user->setJersey($_POST['Jersey']);
        $user->setAbsence($_POST['Absences']);
        $user->setPlayoffs($_POST['Playoffs']);
        $user->setBuddy($_POST['Buddy']);
        $user->setThrowing($_POST['Throwing']);
        $user->setCutting($_POST['Cutting']);
        $user->setSpeed($_POST['Speed']);
        $user->setConditioning($_POST['Conditioning']);
        $user->setExperience($_POST['Experience']);
        $user->setHeight($_POST['Height']);
        $user->setComments($_POST['Comments']);

        $user->MakePersistant($user);

        $reply['success'] = true;
        echo utf8_encode(json_encode($reply, JSON_FORCE_OBJECT));
    } catch (Exception $ex){
        $reply['error'] = true;
    }
}
