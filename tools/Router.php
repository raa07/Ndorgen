<?php

class Router
{

    private static $routes = [];

    static function add($route, $controller, $method)
    {
        self::$routes[] = ['route' => $route,
            'controller_name' => $controller,
            'method_name' => $method];
    }

    static function init()
    {
        foreach (self::$routes as $route_params) {
            extract($route_params);
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            if ($url === $route) {
                $controller_path = __DIR__.'/../app/controllers/'.$controller_name.'.php';
                if (file_exists ( $controller_path)) {
                    require_once($controller_path);
                    $controller = new $controller_name;
                    $controller->$method_name();
                }else return View::result('404');
            }
        }

    }


}