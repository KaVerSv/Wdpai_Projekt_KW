<?php

use models\User;

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $user = $userRepository->getUser($email);

        if (!$user || $user->getEmail() !== $email || $user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Sprawdź swoją nazwę konta oraz hasło i spróbuj ponownie.']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/shop");
    }

    public function register()
    {
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['confirmedPassword'];
        $date = $_POST['date'];

        if ($password !== $confirmedPassword) {
            return $this->render('register', ['messages' => ['Hasła nie są identyczne.']]);
        }

        //TODO try to use better hash function
        $user = new User($email, $username, md5($password), $date);

        $this->userRepository->addUser($user);

        return $this->render('login', ['messages' => ['Utworzono konto.']]);
    }

    public function forgot_password() {
        return  $this->render('forgot_password');
    }

    public function profile() {
        return  $this->render('profile');
    }



}