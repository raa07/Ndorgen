<?php

namespace Tools\Parsers\Title;

use Tools\Parsers\ParserInterface;

final class BingTitleParser extends TitleParser implements ParserInterface//парсер названиев для постов
{

    protected function compareUrl(string $keyword, int $page): string
    {
        $page_count = static::PAGE_COUNT;
        $offset = $page_count * $page;
        $keyword = urlencode($keyword);
        $url = 'https://api.cognitive.microsoft.com/bing/v7.0/search?q='.$keyword.'&count='.$page_count.'&offset='.$offset.'&mkt=ua-UA';

        return $url;
    }
}