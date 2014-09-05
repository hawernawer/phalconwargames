<?php
use Phalcon\Mvc\User\Component;


class Elements extends Component
{
    public function getMenu()
    {

        $auth = $this->session->get('auth');
        if ($auth) {
            ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$auth["name"]?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">

                       <?php
                            echo "<li>".Phalcon\Tag::linkTo('campaign/','Campaigns dashboard')."</li>";
                            echo "<li>".Phalcon\Tag::linkTo('user/','User dashboard')."</li>";
                            echo "<li>".Phalcon\Tag::linkTo('user/logout','Logout')."</li>";
                        ?>

                    </ul>
                </li>
            <?php

        } else {
             echo "<li>".Phalcon\Tag::linkTo('user/login','Login')."</li>";
             echo "<li>".Phalcon\Tag::linkTo('user/signup','Sign up')."</li>";
        }

    }

}