<?php

namespace App;

use App\GlobalModels\Categories;
use App\GlobalModels\Dorgens;
use Tools\Router;


class Dorgen
{
    private static $instance;
    private static $domain;
    private static $category = false;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance() {
        if(null !== self::$instance)
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
        $domain = preg_replace('/[^a-zA-Z0-9]+/', '', $domain);
        self::$domain = $domain;
    }

    public static function getCategorySID()
    {
        if(!static::$category){
            $dorgen_model = new Dorgens();
            $category = $dorgen_model->getCategoryByHost(static::$domain);
            if(!$category) {
                throw new \Exception("ERROR - CATEGORY NOT FOUND");
            }
            static::$category = $category;
        }

        return static::$category['csid'];
    }
}