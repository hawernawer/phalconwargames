<?php

class CampaignController extends ControllerBase
{

    public function indexAction()
    {
        $campaigns = Campaign::find();
        if($campaigns){
            $this->view->setVar('campaigns',$campaigns);
        }


    }

    public function joinAction($campaign)
    {


        $player = new Player();
        $user = new User();
        $player->id_user=$user->getUserFromSession()->id;
        $player->id_campaign= $campaign;
        $player->resources = 0;

        $success = $player->save();

        if(!$success){
            foreach($player->getMessages() as $message){
                echo $message;
            }


        }



    }
}