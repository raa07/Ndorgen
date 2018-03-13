<?php

namespace Tools\Parsers\Title;

use Tools\Parsers\Parser;

//парсер тайтлов
abstract class TitleParser extends Parser
{
    private $results_count;
    private $page;
    private $keyword;

    abstract protected function compareUrl(string $keyword, int $page);

    public function run($keyword, $result_count, $page=0)//отдаём результат парса через эту функцию
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
        $result = [];
        $tries = 0;
        while(count($result) < $this->results_count && $tries <5)//пока не получим нужное кличество тайтлов или пока не накапает 5 попыток
        {
            $url = $this->compareUrl($this->keyword, $this->page);
            $data = $this->request($url);//делаем запрос к поисковику
            $new_result = [];
            foreach ($data as $entity) {
                $title = $entity['name'];
                $title = $this->validate($title);
                if($title) $new_result[] = $title;
            }

            $result = array_merge($result, $new_result);//сливаем результирующие массивы
            $this->page++;//переходим на след страницу
            $tries++;
        }
        return $result;
    }

    protected function validate($title)//валидаця тайтлов
    {
        $title = preg_replace('/(pdf.*)$/', '', $title);
        $title = preg_replace('/(ООО ".*")/', '', $title);
        $title = preg_replace('/(\d{2}\.\d{2}\.\d{4})/', '', $title);
        $title = preg_replace('/(\|)/', '', $title);
        $title = preg_replace('/(\…)/', '', $title);
        $title = preg_replace('/(\.){2,}/', '', $title);
        $title = preg_replace('/[a-zA-Z\-\.0-9]*(href|url|http|www|\.ru|\.com|\.net|\.info|\.org|\.ua)/i', '', $title);
        $title = trim($title);
        if(!preg_match('/([а-яА-Я])/u', $title)) return false;
        if(!preg_match('/( )/u', $title)) return false;

        return $title;
    }

}