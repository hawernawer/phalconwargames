<?php

class Connection extends \Phalcon\Mvc\Model
{

    public $from_province;

    public function getSource()
    {

        return "connection";

    }

    public function initialize()
    {
        $this->hasMany('from_province','Province','id');
    }


}