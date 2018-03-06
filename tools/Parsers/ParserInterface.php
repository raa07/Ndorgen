<?php

namespace Tools\Parsers;

interface ParserInterface
{
    public function run($keyword, $result_count, $page=1);
}