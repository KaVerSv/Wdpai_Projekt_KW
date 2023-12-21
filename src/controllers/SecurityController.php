<?php

use models\User;

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController
{
    public function login() {
        $user = new User('jsnow@gmail.com', 'admin', 'John', 'Snow');

        if ($this->isPost()) {
            return $this->login('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        if ($user -> getEmail() !== $email) {
            return $this-> render('login', ['messages' => ['User with this email does not exist']]);
        }
        if ($user -> getPassword() !== $password) {
            return  $this->render('login', ['messages' => ['wrong password']]);
        }
        return  $this->render('shop');
    }

    public function register() {
        return  $this->render('register');
    }

    public function forgot_password() {
        return  $this->render('forgot_password');
    }

}