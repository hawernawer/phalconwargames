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
    public function newAction()
    {

    }
    public function createAction()
    {
        $this->view->disable();
        if ($this->request->isPost() == true) {

            $description = $this->request->getPost("campaign_description");

                $campaign = new Campaign();
                $campaign->description = $description;
                $this->response->redirect('campaign/');
                $this->flashSession->success('Your campaign has been created successfully!');
                $campaign->create();

        }else{
            $this->flashSession->error('Oooops, something failed and the campaign couldn\'t be created! ');
            $this->response->redirect('campaign/');
        }

    }
    public function joinAction($campaign)
    {
        $this->view->disable();

        $user = new User();
        $tmp_id = $user->getUserFromSession()->id;
        $check_player = Player::findFirst(array(
            "id_user = {$tmp_id} and id_campaign = {$campaign}"
        ));


        if(isset($check_player->id_user)){
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