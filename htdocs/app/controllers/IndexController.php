<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        Phalcon\Tag::appendTitle(":: Home");
        parent::initialize();
    }
    public function indexAction()
    {
        if($this->session->has("auth"))
        {
            $users = User::find("id = '{$this->session->get("auth")["id"]}'");
            $this->view->setVar("user",$users[0]);

        }

    }

    public function testAction()
    {

        $user_campaigns = UsersCampaigns::find();

        foreach ($user_campaigns as $uc)
        {

            echo $uc->id_user;
            echo "<br>";
            echo $uc->id_campaign;

        }

    }

}