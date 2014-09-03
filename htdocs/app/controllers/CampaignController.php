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
        $this->view->disable();

        $user = new User();
        $tmp_id = $user->getUserFromSession()->id;
        $check_player = Player::findFirst(array(
            "id_user = {$tmp_id}",
            "id_campaign = {$campaign}"
        ));


        if(isset($check_player->id)){
            $this->flashSession->error('You are already on that campaign!');
            $this->response->redirect('campaign/');
            return false;
        }

        $player = new Player();

        $player->id_user=$user->getUserFromSession()->id;
        $player->id_campaign= $campaign;
        $player->resources = 0;


        $success = $player->save();

        if(!$success){
            foreach($player->getMessages() as $message){
                echo $message;
            }
        }else{
            $this->flashSession->success('You are now registered in the campaign');
            $this->response->redirect('campaign/');
        }



    }
}