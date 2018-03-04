<?php

namespace Tools\Parsers\Titles;


class TitleParser
{
    protected $titles_save;
    protected $keyword;

    public function __construct($titles_save, $keyword)//количество тайтлов и ключевик для них
    {
        $this->titles_save = $titles_save;
        $this->keyword = $keyword;
    }

    public function run($page=1)//отдаём результат парса через эту функцию
    {
        $titles = $this->parse_titles($page);//парсим тайтлы
        $titles = array_slice($titles, 0, $this->titles_save);//берём только необходимое количество
        return $titles;
    }

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

    protected function validate_titles($titles)//валидаця тайтлов
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
            if(count($result)===$this->titles_save) continue;
            $result[$key] = ucfirst($title);
        }
        return $result;
    }

    protected function parse_titles($page)//парсим тайтлы с page страницы
    {
        $keyword = urlencode($this->keyword);
        $result = [];
        $tries = 0;
        while(count($result) < $this->titles_save && $tries <5)//пока не получим нужное кличество тайтлов или пока не накапает 5 попыток
        {
            $url = $this->compareUrl($keyword, $page);
            $data_title = $this->request($url);//делаем запрос к поисковику

            preg_match_all(static::TITLE_REGEX, $data_title, $matches_title);//получаем сами тайтлы
            $new_result = $this->validate_titles($matches_title[0]);//проводим их валидацию

            $result = array_merge($result, $new_result);//сливаем результирующие массивы
            $page++;//переходим на след страницу
            $tries++;
        }
        return $result;
    }

}