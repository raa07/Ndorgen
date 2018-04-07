<?php

namespace App;

use App\GlobalModels\Dorgens;
use Tools\Router;


class Dorgen
{
    private static $instance = null;
    private static $domain;
    private static $dor = false;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance() {
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

    public static function getHostLink()
    {
        if(!static::$dor) {
            static::initDor();
        }

        return static::$dor['h'];
    }

    public static function setDomain($domain)
    {
        $domain = preg_replace('/[^a-zA-Z0-9]+/', '', $domain);
        self::$domain = $domain;
    }

    private static function initDor()
    {
        $dor_model = new Dorgens();
        $dor = $dor_model->getDorByHost(static::$domain);
        if(!$dor) {
            throw new \Exception("ERROR - CATEGORY NOT FOUND");
        }
        static::$dor = $dor;
    }

    public static function getCategorySID()
    {
        if(!static::$dor) {
            static::initDor();
        }

        return static::$dor['csid'];
    }
}