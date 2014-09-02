<?php

class User extends \Phalcon\Mvc\Model
{

    public function getUserFromSession(){
        $session = $this->getDI()->getShared("session");

        if($session->has("auth"))
        {
            $users = User::find("id = '{$session->get("auth")["id"]}'");
            return $users[0];

        }
    }

}