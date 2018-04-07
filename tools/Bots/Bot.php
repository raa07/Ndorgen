<?php

namespace Tools\Bots;

abstract class Bot
{
    public static $posts_count;
    public static $isInit = false;

    public static function send($text, $link):bool
    {
        if(!static::isActive()){
            return false;
        }
        static::$posts_count--;
        return static::sendPost($text, $link);
    }

    public static function isActive():bool
    {
        if(!static::$isInit) {
            static::init();
        }
        return static::$posts_count !== 0;
    }

    abstract protected static function sendPost($text, $link);

    abstract protected static function init();
}