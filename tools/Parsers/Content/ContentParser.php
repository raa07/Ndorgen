<?php
namespace Tools\Parsers\Content;

use Tools\Parsers\Parser;
//парсер контента
abstract class ContentParser extends Parser
{
    private $results_count;
    private $page;
    private $keyword;
    private $length;

    abstract protected function compareUrl(string $keyword, int $page): string;

    public function run($keyword, $result_count, $length, $page=0)
    {
        $this->keyword = $keyword;
        $this->results_count = $result_count;
        $this->page = $page;
        $this->length = $length;

        $result = $this->parse();

        return $result;
    }

    protected function parse()//получаем ссылки и дискрипшены по ключевику на page странице
    {
        $descs = [];
        $links = [];
        $tries = 0;
        $parse_tries = 0;
        $result = [];

        while(count($links) < $this->results_count && $parse_tries < 5)//пока не получим нужное кличество контента или пока не накапает 5 попыток
        {
            $new_desc='';

            while(strlen($new_desc) < $this->length && $tries < 5) {
                $url = $this->compareUrl($this->keyword, $this->page);
                $data = $this->request($url);

                foreach($data as $entity) {
                    $desc_result = $this->validate($entity['snippet']);//проводим валидацию дискрипшена

                    if($desc_result) {
                        if(strlen($new_desc) >= $this->length) break 1;
                        $new_desc .= '.' . $desc_result;
                        $links[] = $entity['url'];
                    }
                }
                $tries++;
            }
            if(strlen($new_desc) >= $this->length) {
                $result[] = substr($new_desc, 1);
            } else {
                $parse_tries++;
            }
            $tries = 0;
            $this->page++;
        }

        return $result;
    }

    protected function validate($content)//проводим валидацию контента и удаляем всё лишнее
    {
        $content = strip_tags($content);
        $content = preg_replace('/(pdf.*)$/', '', $content);
        $content = preg_replace('/(ООО ".*")/', '', $content);
        $content = preg_replace('/(\d{2}\.\d{2}\.\d{4})/', '', $content);
        $content = preg_replace('/(\|)/', '', $content);
        $content = preg_replace('/(\…)/', '', $content);
        $content = preg_replace('/(\.){2,}/', '', $content);
        $content = preg_replace('/[a-zA-Z\-\.0-9]*(href|url|http|www|\.ru|\.com|\.net|\.info|\.org|\.ua)/i', '', $content);
        $content = trim($content);
        if(!preg_match('/([а-яА-Я])/u', $content)) $result = false;//если нету русских букв
        if(!preg_match('/( )/u', $content)) $result = false;
        if(!isset($result)) $result = ucfirst($content);//делаем первую букву заглавной

        return $result;
    }
}