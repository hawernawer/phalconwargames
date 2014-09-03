<?php

class UserController extends ControllerBase
{
    public function indexAction()
    {
        if($this->session->has('auth'))
        {
            $this->response->redirect('');
        }
    }

    protected function registerSession($user)
    {
        $this->session->set("auth", array(
           "id" => $user->id,
            "email" => $user->email,
            "name" => $user->username,
            "role" => $user->role
        ));
    }

    public function loginAction()
    {
        $this->view->disable();

        if ($this->request->isPost() == true) {

            $email = $this->request->getPost("email", "email");
            $password = $this->request->getPost("password");

            $user = User::findFirst("email = '{$email}'");
            if($user instanceof User)
            {
                if($this->security->checkHash($password, $user->password))
                {
                    $this->registerSession($user);
                    $this->flashSession->success('Welcome back');/*TODO: THIS IS NOT WORKING*/
                    $this->response->redirect('');

                }else{
                    $this->registerSession($user);
                    $this->flashSession->error('Bad!');/*TODO: THIS IS NOT WORKING*/
                    $this->response->redirect('');
                }
            }

        }else{

            $this->response->redirect('user/');
        }
    }
    public function logoutAction()
    {

        $this->session->destroy();
        $this->response->redirect('');
    }

    public function signupAction()
    {


    }

    public function registerAction()
    {
        if ($this->request->isPost() == true) {

            $email = $this->request->getPost("email", "email");
            $password = $this->request->getPost("password");
            $confirmpassword = $this->request->getPost("confirmpassword");
            $username = $this->request->getPost("username");

            $user = User::findFirst("email = '{$email}'");
            if($user instanceof User)
            {
                 $this->flashSession->error('That email is already registered');
                 $this->response->redirect('user/');

            }
            $user = User::findFirst("username = '{$username}'");
            if($user instanceof User)
            {
                $this->flashSession->error('That username is already registered');
                $this->response->redirect('user/');

            }
            //Now we are sure the user doesn't exists, going to create it
            if($password == $confirmpassword)
            {

                $user = new User();
                $user->username = $username;
                $user->email = $email;
                $user->password = $this->security->hash($password);
                $user->role = "user";
                $this->response->redirect('user/');

                $user->create();

            }
        }else{

            $this->response->redirect('user/');
        }

    }
}