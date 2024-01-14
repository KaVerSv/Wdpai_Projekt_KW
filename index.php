<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$PATH = parse_url($path, PHP_URL_PATH);


Routing::get('book_page','BookController');
Routing::get('','DefaultController');
Routing::get('index','BookController');
Routing::get('shop','BookController');
Routing::get('login','SecurityController');
Routing::get('register','SecurityController');
Routing::get('forgot_password','SecurityController');
Routing::get('profile','SecurityController');
Routing::get('library','BookController');
Routing::get('search','BookController');


Routing::run($path);