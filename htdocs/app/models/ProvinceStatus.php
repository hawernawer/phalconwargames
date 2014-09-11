<?php

class ProvinceStatus extends \Phalcon\Mvc\Model
{

    public function getSource()
    {

        return "province_status";

    }

    public function getProvinceStatusWithPointsPerPlayer($player_id)
    {
        $provinces = ProvinceStatus::find(array(
            "id_player = {$player_id} AND points > 0"
        ));
        return $provinces;

    }


}