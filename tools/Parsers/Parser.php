<?php

namespace Tools\Parsers;

abstract class Parser
{
    protected function request($url)//запрос к поисковику
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_USERAGENT, static::USER_AGENT);
        curl_setopt($ch, CURLOPT_FTP_SSL, CURLFTPSSL_TRY);

        $result = curl_exec($ch);

        return $result;
    }

    abstract protected function validate($text);
}