<?php

include_once 'includes.php';

global $config;

function DataConnection($whichdb = null){
    global $config, $conn;
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbName']);
//    $conn = mysqli_connect($config['servername'], $config['username'], $config['password'], $config['dbName']);

    if (mysqli_connect_errno()){
        printf("Can't connect to MySQL server. Errorcode: %s\n", mysqli_connect_error());
    }

    mysqli_set_charset($conn, "utf8");
    return $conn;
}

function data_real_escape_string($result){
    global $conn;
    if ($conn == null){
        $conn = DataConnection();
    }
    return mysqli_real_escape_string($conn, $result);
}

function data_query($query){
    global $conn;
    if ($conn == null){
        $conn = DataConnection();
    }
    return $conn->query($query);
}

function DB_Go($function, $obj, $arg1=''){
    switch($function) {
        case 'find':
            return FindObject($obj, $arg1);
            break;
        case 'makepersistant':
            return PersistObject($obj);
        case 'findall':
            return FindAllObjects($obj, $arg1);
            break;
        default:
            return 'Function does not exist.';
            break;
    }
}

function FindObject($obj, $orderby){
    $tablename = get_class($obj);
    $query = sprintf("select * from %s where ID = '%s';", data_real_escape_string($tablename), data_real_escape_string($obj->getID()));
    $result = data_query($query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    return $obj->Populate($row);
}

function PersistObject($obj){
    global $config;
    $propCount = count((array)$obj);
    $tablename = get_class($obj);
    $count = 0;

    if($obj->_ID != "") {
        $query = sprintf("update %s.%s set ", data_real_escape_string($config['dbName']), data_real_escape_string($tablename));
        foreach($obj as $key => $value){
            $count++;
            $query .= preg_replace('/_/', '', $key, 1) . "='%s'";
            if ($count < $propCount) {
                $query .= ', ';
            }
        }
        $query .= sprintf(" where ID='%s';", $obj->_ID);
        $objects = array();
        foreach($obj as $key => $value){
            array_push($objects, data_real_escape_string($value));
        }
        array_push($objects, $obj->_ID);
        $query = vsprintf($query, $objects);
        $result = data_query($query);

        if(!$result) {
            error_log(data_error(null));
        }
    } else {
        $fields = "";
        $obj->setID(md5(uniqid(rand(), true)));
        $query = sprintf("insert into %s %s values (", data_real_escape_string($tablename), data_real_escape_string($fields));

        foreach($obj as $key => $value){
            $count++;
            $query .= "'" . data_real_escape_string($value) . "'";
            if ($count < $propCount) {
                $query .= ", ";
            }
        }
        $query .= ");";
        $result = data_query($query);

        if(!$result) {
            error_log(data_error(null));
        }

    }

    return $obj;
}

function login(){
    session_start();

    $query = sprintf("select * from user where Email='%s' and Pass='%s';", data_real_escape_string($_POST['email']), data_real_escape_string($_POST['password']));
    $result = data_query($query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (!empty($row)) {
        if ($row['Email'] === $_POST['email'] && $row['Pass'] === $_POST['password']) {
            $_SESSION['PageUserID'] = $row['ID'];
            header("Location: index.php");
            exit();
        }else{
            session_destroy();
            header("Location: login.php?error=Incorect User name or password");
            exit();
        }
    }else{
        session_destroy();
        header("Location: login.php?error=Incorect User name or password");
        exit();
    }
}

function logout(){
    session_unset();
    session_destroy();
    $_SESSION = NULL;
}

