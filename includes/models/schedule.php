<?php

class schedule extends base{
    public $_ID;
    public $_TeamOneID;
    public $_TeamTwoID;
    public $_Date;
    public $_Field;
    public $_TeamOneScore;
    public $_TeamTwoScore;

    public function __construct($id = ''){
        if ($id != '') {
            $this->setID($id);
            $this->Find($this);
        }
    }

    function getID(){
        return $this->_ID;
    }

    function setID($id){
        $this->_ID = $id;
    }

    function getTeamOneID(){
        return $this->_TeamOneID;
    }

    function setTeamOneID($teamoneid){
        $this->_TeamOneID = $teamoneid;
    }

    function getTeamTwoID(){
        return $this->_TeamTwoID;
    }

    function setTeamTwoID($teamtwoid){
        $this->_TeamTwoID = $teamtwoid;
    }

    function getDate(){
        return $this->_Date;
    }

    function setDate($date){
        $this->_Date = $date;
    }

    function getField(){
        return $this->_Field;
    }

    function setField($field){
        $this->_Field = $field;
    }

    function getTeamOneScore(){
        return $this->_TeamOneScore;
    }

    function setTeamOneScore($teamonescore){
        $this->_TeamOneScore = $teamonescore;
    }

    function getTeamTwoScore(){
        return $this->_TeamTwoScore;
    }

    function setTeamTwoScore($teamtwoscore){
        $this->_TeamTwoScore = $teamtwoscore;
    }

    function Populate($post){
        $this->setID((isset($post['ID'])) ? $post['ID'] : $this->_ID);
        $this->setTeamOneID((isset($post['TeamOneID'])) ? $post['TeamOneID'] : $this->_TeamOneID);
        $this->setTeamTwoID((isset($post['TeamTwoID'])) ? $post['TeamTwoID'] : $this->_TeamTwoID);
        $this->setDate((isset($post['Date'])) ? $post['Date'] : $this->_Date);
        $this->setField((isset($post['Field'])) ? $post['Field'] : $this->_Field);
        $this->setTeamOneScore((isset($post['TeamOneScore'])) ? $post['TeamOneScore'] : $this->_TeamOneScore);
        $this->setTeamTwoScore((isset($post['TeamTwoScore'])) ? $post['TeamTwoScore'] : $this->_TeamTwoScore);
        return $this;
    }

}