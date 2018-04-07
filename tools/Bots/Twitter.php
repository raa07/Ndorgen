<?php

namespace Tools\Bots;

class Twitter extends Bot
{
    private static $twitter;
    const API_URL = 'https://api.twitter.com/1.1/';

    protected static function sendPost($text, $link)
    {
        $url = self::API_URL . 'statuses/update.json';
        $method = 'POST';
        $full_text = $text . "\n http://" . Dorgen()->getHostLink() . '/post?id=' . $link;
        $data = [
            'status' => $full_text
        ];

        self::$twitter->buildOauth($url, $method)
            ->setPostfields($data)
            ->performRequest();

        return true;
    }

    protected static function init()
    {
        $runs_per_day = \App\Config::get('general')['runs_per_day'];
        self::$posts_count = (int) floor (99 / $runs_per_day - rand(2, 7));
        $config = \App\Config::get('creds')['twitter'];
        self::$twitter = new \TwitterAPIExchange($config);

    }
}