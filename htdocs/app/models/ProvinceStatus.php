<?php

class ProvinceStatus extends \Phalcon\Mvc\Model
{
    public $id_province;

    public function getSource()
    {

        return "province_status";

    }


    public function initialize()
    {
        $this->belongsTo('id_province','Province','id');
    }
}