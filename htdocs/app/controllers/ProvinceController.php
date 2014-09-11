<?php

class ProvinceController extends ControllerBase
{

    public function indexAction()
    {

        $provinces = Province::find();

       foreach($provinces->connection as $connection){
            echo $connection->to_province;
        }


    }
}