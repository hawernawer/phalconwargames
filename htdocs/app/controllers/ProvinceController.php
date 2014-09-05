<?php

class ProvinceController extends ControllerBase
{

    public function indexAction()
    {

        $province = Province::findFirst();

        $conections = $province->getConnections();

        foreach($conections as $connection){
            echo $connection->from_province."->".$connection->to_province."<br>";
        }


    }
}