<?php

class Permission extends \Phalcon\Mvc\User\Plugin
{

    protected $godResources = array(
        'admin' => array('*')
    );

    protected $userResources = array(
        'user' => array('*'),
    );

    //Public area resources (frontend)
    protected $publicResources = array(
        'index' => array('*'),
        'user' => array('index','login','signup')
    );

    protected function getAcl()
    {
        if(!isset($this->persistent->acl)){

            $acl = new Phalcon\Acl\Adapter\Memory();
            $acl->setDefaultAction(\Phalcon\Acl::DENY);

            $roles = array(
                'god' => new Phalcon\Acl\Role('god'),
                'user' => new Phalcon\Acl\Role('user'),
                'guest' => new Phalcon\Acl\Role('guest')
            );

            foreach($roles as $role){

                $acl->addRole($role);
            }

            foreach($this->godResources as $resource => $actions){

                $acl->addResource(new Phalcon\Acl\Resource($resource),$actions);
            }

            foreach($this->userResources as $resource => $actions){

                $acl->addResource(new Phalcon\Acl\Resource($resource),$actions);
            }

            foreach($this->publicResources as $resource => $actions){

                $acl->addResource(new Phalcon\Acl\Resource($resource),$actions);
            }


            foreach($roles as $role){
                foreach($this->publicResources as $resource => $actions){
                    foreach($actions as $action){
                        $acl->allow($role->getName(), $resource, $action);
                    }

                }

            }
            foreach($this->userResources as $resource => $actions){
                foreach($actions as $action){
                    $acl->allow('user', $resource, $action);
                    $acl->allow('god', $resource, $action);
                }

            }
            foreach($this->godResources as $resource => $actions){
                foreach($actions as $action){
                    $acl->allow('god',$resource,$action);

                }
            }

            $this->persistent->acl = $acl;

        }

        return $this->persistent->acl;

    }

    public function beforeExecuteRoute(\Phalcon\Events\Event $event,\Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $role = $this->session->get('auth')['role'];

        if(!$role){
            $role = 'guest';
        }

        $controllerName = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $acl = $this->getAcl();

        $allowed = $acl->isAllowed($role,$controllerName,$action);

        if($allowed!=\Phalcon\Acl::ALLOW){
            $dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'

            ));
            $this->flashSession->error('You are not allowed to go in there motherfucker');
            return false;
        }

    }
}