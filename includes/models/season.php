<?php

class season extends base {

    public $_ID;
    public $_Name;
    public $_StartDate;
    public $_EndDate;
    public $_PlayoffDate;
    public $_Info;

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

    function getName(){
        return $this->_Name;
    }

    function setName($name){
        $this->_Name = $name;
    }

    function getStartDate(){
        return $this->_StartDate;
    }

    function setStartDate($startdate){
        $this->_StartDate = $startdate;
    }

    function getEndDate(){
        return $this->_EndDate;
    }

    function setEndDate($enddate){
        $this->_EndDate = $enddate;
    }

    function getPlayoffDate(){
        return $this->_PlayoffDate;
    }

    function setPlayoffDate($playoffdate){
        $this->_PlayoffDate = $playoffdate;
    }

    function getInfo(){
        return $this->_Info;
    }

    function setInfo($info){
        $this->_Info = $info;
    }

    function Populate($post){
        $this->setID((isset($post['ID'])) ? $post['ID'] : $this->_ID);
        $this->setName((isset($post['Name'])) ? $post['Name'] : $this->_Name);
        $this->setStartDate((isset($post['StartDate'])) ? $post['StartDate'] : $this->_StartDate);
        $this->setEndDate((isset($post['EndDate'])) ? $post['EndDate'] : $this->_EndDate);
        $this->setPlayoffDate((isset($post['PlayoffDate'])) ? $post['PlayoffDate'] : $this->_PlayoffDate);
        $this->setInfo((isset($post['Info'])) ? $post['Info'] : $this->_Info);
        return $this;
    }

}