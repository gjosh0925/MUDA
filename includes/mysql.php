<?php

include_once 'includes.php';

global $config;

function DataConnection($whichdb = null){
    global $config, $conn;
    $conn = new mysqli($config['servername'] . ":" . $config['portnum'], $config['username'], $config['password'], $config['dbName']);

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
        case 'makepersistant':
            return PersistObject($obj);
        case 'findall':
            return FindAllObjects($obj, $arg1);
        case 'FindAllByParams':
            return FindAllByParams($obj, $arg1, $arg2 = 'ID');
        case 'delete':
            return DeleteObject($obj);
        default:
            return 'Function does not exist.';
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

function FindAllByParams($obj, $params, $orderby){
    $objs = array();
    $fld = $params["fld"];
    $val = $params["val"];
    $fld2 = isset($params["fld2"]) ? $params["fld2"] : "";
    $val2 = isset($params["val2"]) ? $params["val2"] : "";
    $fld3 = isset($params["fld3"]) ? $params["fld3"] : "";
    $val3 = isset($params["val3"]) ? $params["val3"] : "";
    $opp = isset($params["opp"]) ? $params["opp"] : "=";
    $opp2 = isset($params["opp2"]) ? $params["opp2"] : "=";
    $opp3 = isset($params["opp3"]) ? $params["opp3"] : "=";

    $tablename = get_class($obj);
    $query = "";

    if ($fld3 != ""){
        $query = sprintf("select * from %s where %s %s '%s' and %s %s '%s' and %s %s '%s' order by %s",
        data_real_escape_string($tablename),
        data_real_escape_string($fld), data_real_escape_string($opp), data_real_escape_string($val),
        data_real_escape_string($fld2), data_real_escape_string($opp2), data_real_escape_string($val2),
        data_real_escape_string($fld3), data_real_escape_string($opp3), data_real_escape_string($val3),
        data_real_escape_string($orderby));
    } else if ($fld2 != ""){
        $query = sprintf("select * from %s where %s %s '%s' and %s %s '%s' order by %s",
        data_real_escape_string($tablename),
        data_real_escape_string($fld), data_real_escape_string($opp), data_real_escape_string($val),
        data_real_escape_string($fld2), data_real_escape_string($opp2), data_real_escape_string($val2),
        data_real_escape_string($orderby));
    } else {
        $query = sprintf("select * from %s where %s %s '%s' order by %s",
        data_real_escape_string($tablename),
        data_real_escape_string($fld), data_real_escape_string($opp), data_real_escape_string($val),
        data_real_escape_string($orderby));
    }

    $result = data_query($query);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $newobj = new $tablename;
        array_push($objs, $newobj->Populate($row));
    }

    return $objs;
}

function login(){
    session_start();

    $query = sprintf("select * from user where Email='%s' and Pass='%s';", data_real_escape_string($_POST['email']), data_real_escape_string($_POST['password']));
    $result = data_query($query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (!empty($row)) {
        if ($row['Email'] === $_POST['email'] && $row['Pass'] === $_POST['password']) {
            $_SESSION['PageUserID'] = $row['ID'];
            header("Location: index.php?success=logged_in");
            $_SESSION['success'] = '1';
            exit();
        }else{
            session_destroy();
            header("Location: login.php?error=Incorect Email or Password");
            exit();
        }
    }else{
        session_destroy();
        header("Location: login.php?error=Incorect Email or Password");
        exit();
    }
}

function DeleteObject($obj){
    $tablename = get_class($obj);
    $query = sprintf("delete from %s where ID = '%s';", data_real_escape_string($tablename), data_real_escape_string($obj->getID()));
    $result = data_query($query);
}

function logout(){
    session_unset();
    session_destroy();
    $_SESSION = NULL;
}

