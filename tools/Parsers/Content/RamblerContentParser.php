<?php

namespace Tools\Parsers\Content;

use Tools\Parsers\ParserInterface;

final class RamblerContentParser extends ContentParser implements ParserInterface
{
    const USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36';

    const DESC_REGEX = '/<p class="b-serp-item__snippet">(.+?)<\/p>/is';
    const LINK_REGEX = '/<a target="_blank" tabindex="2" class="b-serp-item__link" href="(.+?)"/is';


    protected function compareUrl($keyword, $page)
    {
        $url = 'https://nova.rambler.ru/search?scroll=1&utm_source=nhp&utm_content=search&utm_medium=button&utm_campaign=self_promo&query='.$keyword.'&page='.$page;
        return $url;
    }
}