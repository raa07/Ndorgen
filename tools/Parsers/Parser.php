<?php

namespace Tools\Parsers;

abstract class Parser
{
    const API_KEY = 'e3e0f964ccf040d99948a9dea839b082';
    const PAGE_COUNT = 5;

    protected function request($url, $page_count = self::PAGE_COUNT)//запрос к поисковику
    {
        $GLOBALS['tries']++;
        if($GLOBALS['tries'] >= 50) {
            die('api request limit');
        }
        $accountKey = static::API_KEY;
        
        $opts = [
            'http'=>[
                'method'=>"GET",
                'header'=>'Ocp-Apim-Subscription-Key: '.$accountKey
            ]
        ];
        $context = stream_context_create($opts);

        $file = file_get_contents($url, false, $context);

        $page = json_decode($file, true);

        $result = [];

        if(isset($page['webPages']))
        {
            if(isset($page['webPages']['value'])){
                $result = $page['webPages']['value'];
            }
        }

       return $result;
    }

    abstract protected function validate($text);
}