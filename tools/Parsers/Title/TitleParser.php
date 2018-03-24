<?php
namespace Tools\Parsers\Title;

use Tools\Parsers\Parser;
//парсер тайтлов
abstract class TitleParser extends Parser
{
    private $results_count;
    private $page;
    private $keyword;
    private $length;

    abstract protected function compareUrl(string $keyword, int $page);

    public function run($keyword, $result_count, $length, $page=0)//отдаём результат парса через эту функцию
    {
        $this->results_count = $result_count;
        $this->page = $page;
        $this->keyword = $keyword;
        $this->length = $length;

        $titles = $this->parse();//парсим тайтлы

        $titles = array_slice($titles, 0, $this->results_count);//берём только необходимое количество
        return $titles;
    }

    protected function parse()//парсим тайтлы с page страницы
    {
        $result = [];
        $tries = 0;
        $parse_tries = 0;

        while(count($result) < $this->results_count && $parse_tries <5)//пока не получим нужное кличество тайтлов или пока не накапает 5 попыток
        {
            $new_title = '';

            while(mb_strlen($new_title) < $this->length && $tries < 5) {
                $url = $this->compareUrl($this->keyword, $this->page);
                $data = $this->request($url);//делаем запрос к поисковику

                foreach ($data as $entity) {
                    /////////////////////
                    $title = $entity['name'];
                    $title = $this->validate($title);
                    if($title){
                        if(mb_strlen($new_title) >= $this->length) break 1;
                        $new_title .= ' - ' . $title;
                    }
                }
                $tries++;
            }

            if(mb_strlen($new_title) >= $this->length) {
                $result[] = substr($new_title, 3);
            } else {
                $parse_tries++;
            }

            $tries = 0;
            $this->page++;
        }
        return $result;
    }

    protected function validate($title)//валидаця тайтлов
    {
        $title = preg_replace('/([-_])/', '', $title);
        $title = preg_replace('/^([\.,])/', '', $title);
        $title = preg_replace('/(pdf.*)$/', '', $title);
        $title = preg_replace('/(ООО ".*")/', '', $title);
        $title = preg_replace('/(\d{2}\.\d{2}\.\d{4})/', '', $title);
        $title = preg_replace('/(\|)/', '', $title);
        $title = preg_replace('/(\…)/', '', $title);
        $title = preg_replace('/(\.){2,}/', '', $title);
        $title = preg_replace('/[a-zA-Z\-\.0-9]*(href|url|http|www|\.ru|\.com|\.net|\.info|\.org|\.ua|\.by)/i', '', $title);
        $title = trim($title);
        $title = preg_replace('/(\s.)$/u', '', $title);

        if(substr_count($title, ' ') <= 2) {
            return false;
        }
        if(!preg_match('/([а-яА-Я])/u', $title)) return false;
        if(!preg_match('/( )/u', $title)) return false;

        return $title;
    }

}