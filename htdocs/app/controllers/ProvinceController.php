<?php

class ProvinceController extends ControllerBase
{

    public function indexAction()
    {

        $province = Province::findFirst();

        foreach($province->connection as $connection)
        {

                echo $connection->to_province;

        }


    }
}