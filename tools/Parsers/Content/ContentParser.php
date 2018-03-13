<?php
namespace Tools\Parsers\Content;

use Tools\Parsers\Parser;

//парсер контента
abstract class ContentParser extends Parser
{
    private $results_count;
    private $page;
    private $keyword;

    abstract protected function compareUrl(string $keyword, int $page): string;

    public function run($keyword, $result_count, $page=0)
    {
        $this->keyword = $keyword;
        $this->results_count = $result_count;
        $this->page = $page;

        $result = $this->parse();

        return $result;
    }

    protected function parse()//получаем ссылки и дискрипшены по ключевику на page странице
    {
        $descs = [];
        $links = [];
        $tries = 0;
        $result = [];

        while(count($links) < $this->results_count && $tries <5)//пока не получим нужное кличество контента или пока не накапает 5 попыток
        {
            $url = $this->compareUrl($this->keyword, $this->page);
            $data = $this->request($url);

            foreach($data as $entity)
            {
                $desc_result = $this->validate($entity['snippet']);//проводим валидацию дискрипшена

                if($desc_result) {
                    $descs[] = $desc_result;
                    $links[] = $entity['url'];
                }
            }

            $this->page++;//переходим на след страницу
            $tries++;
        }


        foreach($descs as $key => $desc){
            if($key === $this->results_count) break;
            $result[$links[$key]] = $desc;
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