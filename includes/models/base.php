<?php

class base {
    public function __construct(){

    }

    public function Find($obj, $orderby = 'ID'){
        return DB_Go('find', $obj, $orderby);
    }

    public function MakePersistant($obj){
        return DB_Go('makepersistant', $obj);
    }

    public function FindByParams($params = array()){
        return DB_Go('FindByParams', $this, $params);
    }

    public function FindAllByParams($params = array(), $orderby='ID'){
        return DB_Go('FindAllByParams', $this, $params, $orderby);
    }

    public function Delete($obj){
        return DB_Go('delete', $obj);
    }
}