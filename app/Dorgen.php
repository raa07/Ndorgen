<?php


class Dorgen
{
    private static $instance = null;

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
        return Router::init();
    }

    public static function getDomain()
    {
        return $_SERVER['SERVER_NAME'];
    }


}