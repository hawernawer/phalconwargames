<?php

class Player extends \Phalcon\Mvc\Model
{

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

}