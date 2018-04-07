<?php

namespace Tools\Parsers;

abstract class Parser
{
    const PAGE_COUNT = 5;

    protected function request($url, $page_count = self::PAGE_COUNT)//запрос к поисковику
    {
        $GLOBALS['tries']++;
        if($GLOBALS['tries'] >= \App\Config::get('generators')['api_tries']) {
            echo 'api request limit';
            return false;
        }
        $accountKey = \App\Config::get('creds')['azure'];
        
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