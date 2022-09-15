<?php

class user extends base {
    public $_ID;
    public $_Username;
    public $_Password;
    public $_UserRole;
    public $_TeamID;
    public $_Tstamp;
    public $_Nickname;
    public $_Phone;
    public $_Email;
    public $_Gender;
    public $_Jersey;
    public $_DOB;
    public $_Absence;
    public $_Playoffs;
    public $_Buddy;
    public $_Verified;
    public $_Throwing;
    public $_Cutting;
    public $_Speed;
    public $_Conditioning;
    public $_Experience;
    public $_Height;
    public $_Comments;

    public function __construct($id = ''){
        if ($id != ''){
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

    function getUsername(){
        return $this->_Username;
    }

    function setUsername($username){
        $this->_Username = $username;
    }

    function getPassword(){
        return $this->_Password;
    }

    function setPassword($password){
        $this->_Password = $password;
    }

    function getUserRole(){
        return $this->_UserRole;
    }

    function setUserRole($userRole){
        $this->_UserRole = $userRole;
    }

    function getTeamID(){
        return $this->_TeamID;
    }

    function setTeamID($teamid){
        $this->_TeamID = $teamid;
    }

    function getTstamp(){
        return $this->_Tstamp;
    }

    function setTstamp($tstamp){
        $this->_Tstamp = $tstamp;
    }

    function getNickname(){
        return $this->_Nickname;
    }

    function setNickname($nickname){
        $this->_Nickname = $nickname;
    }

    function getPhone(){
        return $this->_Phone;
    }

    function setPhone($phone){
        $this->_Phone = $phone;
    }

    function getEmail(){
        return $this->_Email;
    }

    function setEmail($email){
        $this->_Email = $email;
    }

    function getGender(){
        return $this->_Gender;
    }

    function setGender($gender){
        $this->_Gender = $gender;
    }

    function getJersey(){
        return $this->_Jersey;
    }

    function setJersey($jersey){
        $this->_Jersey = $jersey;
    }

    function getDOB(){
        return $this->_DOB;
    }

    function setDOB($dob){
        $this->_DOB = $dob;
    }

    function getAbsence(){
        return $this->_Absence;
    }

    function setAbsence($absence){
        $this->_Absence = $absence;
    }

    function getPlayoffs(){
        return $this->_Playoffs;
    }

    function setPlayoffs($playoffs){
        $this->_Playoffs = $playoffs;
    }

    function getBuddy(){
        return $this->_Buddy;
    }

    function setBuddy($buddy){
        $this->_Buddy = $buddy;
    }

    function getVerified(){
        return $this->_Verified;
    }

    function setVerified($verified){
        $this->_Verified = $verified;
    }

    function getThrowing(){
        return $this->_Throwing;
    }

    function setThrowing($throwing){
        $this->_Throwing = $throwing;
    }

    function getCutting(){
        return $this->_Cutting;
    }

    function setCutting($cutting){
        $this->_Cutting = $cutting;
    }

    function getSpeed(){
        return $this->_Speed;
    }

    function setSpeed($speed){
        $this->_Speed = $speed;
    }

    function getConditioning(){
        return $this->_Conditioning;
    }

    function setConditioning($conditioning){
        $this->_Conditioning = $conditioning;
    }

    function getExperience(){
        return $this->_Experience;
    }

    function setExperience($experience){
        $this->_Experience = $experience;
    }

    function getHeight(){
        return $this->_Height;
    }

    function setHeight($height){
        $this->_Height = $height;
    }

    function getComments(){
        return $this->_Comments;
    }

    function setComments($comments){
        $this->_Comments = $comments;
    }


    function Populate($post){
        $this->setID((isset($post['ID'])) ? $post['ID'] : $this->_ID);
        $this->setUsername((isset($post['Username'])) ? $post['Username'] : $this->_Username);
        $this->setPassword((isset($post['Password'])) ? $post['Password'] : $this->_Password);
        $this->setUserRole((isset($post['UserRole'])) ? $post['UserRole'] : $this->_UserRole);
        $this->setTeamID((isset($post['TeamID'])) ? $post['TeamID'] : $this->_TeamID);
        $this->setTstamp((isset($post['Tstamp'])) ? $post['Tstamp'] : $this->_Tstamp);
        $this->setNickname((isset($post['Nickname'])) ? $post['Nickname'] : $this->_Nickname);
        $this->setPhone((isset($post['Phone'])) ? $post['Phone'] : $this->_Phone);
        $this->setEmail((isset($post['Email'])) ? $post['Email'] : $this->_Email);
        $this->setGender((isset($post['Gender'])) ? $post['Gender'] : $this->_Gender);
        $this->setJersey((isset($post['Jersey'])) ? $post['Jersey'] : $this->_Jersey);
        $this->setDOB((isset($post['DOB'])) ? $post['DOB'] : $this->_DOB);
        $this->setAbsence((isset($post['Absence'])) ? $post['Absence'] : $this->_Absence);
        $this->setPlayoffs((isset($post['Playoffs'])) ? $post['Playoffs'] : $this->_Playoffs);
        $this->setBuddy((isset($post['Buddy'])) ? $post['Buddy'] : $this->_Buddy);
        $this->setVerified((isset($post['Verified'])) ? $post['Verified'] : $this->_Verified);
        $this->setThrowing((isset($post['Throwing'])) ? $post['Throwing'] : $this->_Throwing);
        $this->setCutting((isset($post['Cutting'])) ? $post['Cutting'] : $this->_Cutting);
        $this->setSpeed((isset($post['Speed'])) ? $post['Speed'] : $this->_Speed);
        $this->setConditioning((isset($post['Conditioning'])) ? $post['Conditioning'] : $this->_Conditioning);
        $this->setExperience((isset($post['Experience'])) ? $post['Experience'] : $this->_Experience);
        $this->setHeight((isset($post['Height'])) ? $post['Height'] : $this->_Height);
        $this->setComments((isset($post['Comments'])) ? $post['Comments'] : $this->_Comments);
        return $this;
    }
}