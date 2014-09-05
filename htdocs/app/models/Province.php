<?php

class Province extends \Phalcon\Mvc\Model
{

    public function getSource()
    {

        return "province";

    }


    public function getConnections(){

        $connections= Connection::find(array(
            "from_province = {$this->id}"
        ));

        return $connections;

    }
}