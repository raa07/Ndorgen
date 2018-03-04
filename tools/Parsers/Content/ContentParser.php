<?php
namespace Tools\Parsers\Content;

class ContentParser//парсер контента
{
    private function request($url)//запрос к поиску
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_USERAGENT, static::USER_AGENT);
        curl_setopt($ch, CURLOPT_FTP_SSL, CURLFTPSSL_TRY);
        $result = curl_exec($ch);
        return $result;
    }
    public function parse_links_desc($keyword, $page=1)//получаем ссылки и дискрипшены по ключевику на page странице
    {
        $url = $this->compareUrl($keyword, $page);
        $data = $this->request($url);

        preg_match_all(static::DESC_REGEX, $data, $descs);//получаем дискрипшенны
        preg_match_all(static::LINK_REGEX, $data, $links);//получаем ссылки

        $descs = $descs[0];
        $links = $links[1];
        foreach($descs as $key=>$desc)
        {
            $desc_result = $this->validate_content($desc);//проводим валидацию дискрипшена
            if(!$desc_result){
                unset($descs[$key]);
                unset($links[$key]);//плохой контент - выбрасываем ссылку
            }
            else $descs[$key] = $desc_result;
        }
        return [$links, $descs];
    }
    public function validate_content($content)//проводим валидацию контента и удаляем всё лишнее
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
        $result = ucfirst($content);//делаем первую букву заглавной

        return $result;
    }
}