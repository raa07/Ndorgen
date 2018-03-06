<?php
namespace Tools\Parsers\Content;

use Tools\Parsers\Parser;

//парсер контента
class ContentParser extends Parser
{
    private $results_count;
    private $page;
    private $keyword;

    public function run($keyword, $result_count, $page=1)
    {
        $result = $this->parse();

        array_slice($result, 0, $this->results_count);//берём только необходимое количество
        return $result;
    }

    protected function parse()//получаем ссылки и дискрипшены по ключевику на page странице
    {
        $url = $this->compareUrl($this->keyword, $this->page);
        $data = $this->request($url);

        preg_match_all(static::DESC_REGEX, $data, $descs);//получаем дискрипшенны
        preg_match_all(static::LINK_REGEX, $data, $links);//получаем ссылки

        $descs = $descs[0];
        $links = $links[1];
        foreach($descs as $key=>$desc)
        {
            $desc_result = $this->validate($desc);//проводим валидацию дискрипшена
            if(!$desc_result){
                unset($descs[$key]);
                unset($links[$key]);//плохой контент - выбрасываем ссылку
            }
            else $descs[$key] = $desc_result;
        }
        return [$links, $descs];
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