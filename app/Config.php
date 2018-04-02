<?php

namespace App;

class Config
{
    private static $config;

    public static function init($config_path)
    {
        self::$config = [];
        if(file_exists($config_path)) {
            require($config_path);
            self::$config = $configs;
        }
    }

    public static function get(string $field, $default = false)
    {
        return self::$config[$field] ?? $default;
    }
}