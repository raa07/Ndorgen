<?php

namespace App;

use Tools\Router;


class Dorgen
{
    private static $instance = null;
    private static $domain;

    private function __construct(){}
    private function __clone(){}

    static public function getInstance() {
        if(is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function init()
    {
        self::setDomain($_SERVER['SERVER_NAME']);
        return Router::init();
    }

    public static function getDomain()
    {
        return self::$domain;
    }

    public static function setDomain($domain)
    {
        self::$domain = $domain;
    }

//todo: тут реализовать 0 - возрат категории дора
}