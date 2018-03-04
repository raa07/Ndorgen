<?php

namespace Tools\Parsers\Titles;

class TitleRambler extends TitleParser//парсер названиев для постов
{
    const USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36';

    const TITLE_REGEX = '/<h2 class="b-serp-item__title">(.+?)<\/h2>/is';

    protected function compareUrl($keyword, $page)
    {
        return 'https://nova.rambler.ru/search?scroll=1&utm_source=nhp&utm_content=search&utm_medium=button&utm_campaign=self_promo&query='.$keyword.'&page='.$page;
    }

}