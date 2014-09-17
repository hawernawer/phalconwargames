<?php

class Player extends \Phalcon\Mvc\Model
{
    public $id;
    public function getSource()
    {

        return "player";

    }

    public function getPlayersInCampaign($campaign){
        $players = Player::find(array(
            "id_campaign = {$campaign}"
        ));
        return $players;
    }
    public function playerIsInCampaign($campaign_id,$user_id){
        $player = Player::findFirst(array(
            "id_campaign = {$campaign_id} and id_user = {$user_id}"
        ));

        if(isset($player->id)){
            return true;
        }else{
            return false;
        }
    }
    public function retrievePlayerWithID($id){
        $player = Player::find(array(
           "id = {$id}"
        ));
        return $player;
    }
    public function getProvincesWithPoints($id){
        $provinceStatus = ProvinceStatus::findFirst(array(
           "id_player = {$id}"
        ));
        $provinces = Province::find(array(
            "id = {$provinceStatus->id_province}"
        ));
        /**
         * TODO I have to do the method aboved in a proper way, I need to return the array and
         * search the array of provinceStatus. Research about models
         */
        return $provinces;
    }


}