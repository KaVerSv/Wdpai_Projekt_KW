<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/BookController.php';

class Routing {
    public static $routes;

    public static function get($url, $controller) {
        self::$routes[$url] = $controller;
    }
    public static function post($url, $controller) {
        self::$routes[$url] = $controller;
    }

    /*
    public static function run($url) {
        $urlParts = explode("/", $url);
        $action = $urlParts[0];

        // warunek dla braku argumentow -> strona glowna
        if (empty($action)) {
            $action = 'shop'; // Domyślna ścieżka dla pustego adresu
        }

        if (!array_key_exists($action, self::$routes)) {
            die("Wrong url");
        }

        $controller = self::$routes[$action];
        $object = new $controller;

        $id = $urlParts[1] ?? '';

        $object->$action($id);
    }
    */

    public static function run($url) {
        $urlParts = explode("?", $url); // Rozdziel adres URL na część przed "?" i po "?"
        $action = $urlParts[0];

        // Warunek dla braku argumentów -> strona główna
        if (empty($action)) {
            $action = 'shop'; // Domyślna ścieżka dla pustego adresu
        }

        if (!array_key_exists($action, self::$routes)) {
            die("Wrong url");
        }

        $controller = self::$routes[$action];
        $object = new $controller;

        // Jeśli są parametry zapytań, przekazujemy je do akcji kontrolera
        if (count($urlParts) > 1) {
            $queryParameters = $urlParts[1];
            parse_str($queryParameters, $queryParams);
            $object->$action($queryParams);
        } else {
            // Bez parametrów zapytań
            $object->$action();
        }
    }
}
