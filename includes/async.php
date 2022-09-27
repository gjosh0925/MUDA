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
    //select all teams
    //select all players

}
