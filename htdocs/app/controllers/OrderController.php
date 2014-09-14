<?php

class OrderController extends ControllerBase
{

    public function indexAction()
    {
        echo "You are in the Order controller";
    }
    public function createAction($campaign){
        $auth = $this->session->get('auth');
        $check_player = new Player();
        if(!$check_player->playerIsInCampaign($campaign,$auth["id"])){
            $this->view->disable();
            $this->flashSession->error('You can\'t create orders in a campaign that you are not playing');
            $this->response->redirect('user/dashboard');
            return false;
        }



        //$this->view->setVar('provinces_from',$provinces);

    }

}