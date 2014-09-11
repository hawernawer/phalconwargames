<?php

class Province extends \Phalcon\Mvc\Model
{

    public $id;
    public $name;

    public function getSource()
    {

        return "province";

    }
    public function getProvinceStatusWithPointsPerPlayer($player_id)
    {
        $provinces_status = ProvinceStatus::find(array(
            "id_player = {$player_id} AND points > 0"
        ));

        $provinces = Province::find(array(
           "id in {$provinces_status->id_province}"
        ));
        //todo change and return provinces, not provincestatus
        return $provinces;

    }

    public function initialize(){
        $this->hasMany('id','Connection','from_province');
        $this->hasMany('id','ProvinceStatus','id_province');
    }

}