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


        if ($this->request->isPost() == true) {

            $email = $this->request->getPost("email", "email");
            $password = $this->request->getPost("password");

            $user = User::findFirst("email = '{$email}'");
            if($user instanceof User)
            {
                if($this->security->checkHash($password, $user->password))
                {
                    $this->registerSession($user);
                    $this->response->redirect('');
                    // TODO Tell user they are logged in
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

                 $this->response->redirect('user/');
                 // TODO Tell user that email is already registered

            }
            $user = User::findFirst("username = '{$username}'");
            if($user instanceof User)
            {
                $this->response->redirect('user/');
                // TODO Tell user that username is already registered

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