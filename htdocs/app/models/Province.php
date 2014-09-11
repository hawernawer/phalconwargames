<?php

class Province extends \Phalcon\Mvc\Model
{

    public function getSource()
    {

        return "province";

    }


    public function initialize(){
        $this->hasMany('connections','Connection','from_province');
    }
}