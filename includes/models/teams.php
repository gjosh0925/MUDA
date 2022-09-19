<?php

class teams extends base
{
    public $_ID;
    public $_Name;
    public $_CaptainID;
//    public $_Players;
//    public $_GameTimes;
    public $_Rank;

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

    function getCaptainID(){
        return $this->_CaptainID;
    }

    function setCaptainID($captainid){
        $this->_CaptainID = $captainid;
    }

    function getRank(){
        return $this->_Rank;
    }

    function setRank($rank){
        $this->_Rank = $rank;
    }

    function Populate($post){
        $this->setID((isset($post['ID'])) ? $post['ID'] : $this->_ID);
        $this->setName((isset($post['Name'])) ? $post['Name'] : $this->_Name);
        $this->setCaptainID((isset($post['CaptainID'])) ? $post['CaptainID'] : $this->_CaptainID);
        $this->setRank((isset($post['Rank'])) ? $post['Rank'] : $this->_Rank);
        return $this;
    }

}