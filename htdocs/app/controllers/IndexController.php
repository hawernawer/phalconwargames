<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {



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