<?php

namespace Tools\Parsers;

abstract class Parser
{
    const API_KEY = '42f2fa2b199943008675f3ac7a6b67b8';
    const PAGE_COUNT = 10;

    protected function request($url)//запрос к поисковику
    {

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