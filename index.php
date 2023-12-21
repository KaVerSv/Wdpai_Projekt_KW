<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$PATH = parse_url($path, PHP_URL_PATH);

Routing::get('','DefaultController');
Routing::get('index','DefaultController');
Routing::get('shop','DefaultController');
Routing::get('login','SecurityController');
Routing::get('register','SecurityController');
Routing::get('forgot_password','SecurityController');
Routing::get('profile','SecurityController');
Routing::get('library','SecurityController');

Routing::run($path);