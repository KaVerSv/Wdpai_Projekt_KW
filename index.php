<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$PATH = parse_url($path, PHP_URL_PATH);

Routing::get('index','DefaultController');
Routing::get('shop','DefaultController');
Routing::get('login','SecurityController');

Routing::run($path);