<?php

class Province extends \Phalcon\Mvc\Model
{

    public $id;
    public $name;

    public function getSource()
    {

        return "province";

    }

    public function initialize(){
        $this->hasMany('id','Connection','from_province');
        $this->hasMany('id','ProvinceStatus','id_province');
    }

}