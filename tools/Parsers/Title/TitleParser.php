<?php

namespace Tools\Parsers\Title;

use Tools\Parsers\Parser;

//парсер тайтлов
class TitleParser extends Parser
{
    private $results_count;
    private $page;
    private $keyword;

    public function run($keyword, $result_count, $page=1)//отдаём результат парса через эту функцию
    {
        $this->results_count = $result_count;
        $this->page = $page;
        $this->keyword = $keyword;

        $titles = $this->parse();//парсим тайтлы

        $titles = array_slice($titles, 0, $this->results_count);//берём только необходимое количество
        return $titles;
    }

    protected function parse()//парсим тайтлы с page страницы
    {
        $keyword = urlencode($this->keyword);
        $result = [];
        $tries = 0;
        while(count($result) < $this->results_count && $tries <5)//пока не получим нужное кличество тайтлов или пока не накапает 5 попыток
        {
            $url = $this->compareUrl($keyword, $this->page);
            $data_title = $this->request($url);//делаем запрос к поисковику

            preg_match_all(static::TITLE_REGEX, $data_title, $matches_title);//получаем сами тайтлы
            $new_result = $this->validate($matches_title[0]);//проводим их валидацию

            $result = array_merge($result, $new_result);//сливаем результирующие массивы
            $this->page++;//переходим на след страницу
            $tries++;
        }
        return $result;
    }

    protected function validate($titles)//валидаця тайтлов
    {
        $result = [];
        foreach($titles as $key => $title)//удаляем все лишнее и смотрим осталось ли что-то
        {
            $title = strip_tags($title);
            $title = preg_replace('/(pdf.*)$/', '', $title);
            $title = preg_replace('/(ООО ".*")/', '', $title);
            $title = preg_replace('/(\d{2}\.\d{2}\.\d{4})/', '', $title);
            $title = preg_replace('/(\|)/', '', $title);
            $title = preg_replace('/(\…)/', '', $title);
            $title = preg_replace('/(\.){2,}/', '', $title);
            $title = preg_replace('/[a-zA-Z\-\.0-9]*(href|url|http|www|\.ru|\.com|\.net|\.info|\.org|\.ua)/i', '', $title);
            $title = trim($title);
            if(!preg_match('/([а-яА-Я])/u', $title)) continue;
            if(!preg_match('/( )/u', $title)) continue;
            if(count($result)===$this->results_count) continue;
            $result[$key] = ucfirst($title);
        }
        return $result;
    }
}