<?php

class Connection extends \Phalcon\Mvc\Model
{

    public $from_province;
    public $id;
    public function getSource()
    {

        return "connection";

    }

    public function initialize()
    {
        $this->belongsTo('from_province','Province','id');
    }


}