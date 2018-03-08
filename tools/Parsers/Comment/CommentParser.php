<?php
namespace Tools\Parsers\Comment;

use Tools\Parsers\Parser;

class CommentParser extends Parser
{

    private $results_count;
    private $page;
    private $keyword;

    public function run($keyword, $result_count, $page=1)
    {
        $this->keyword = $keyword;
        $this->results_count = $result_count;
        $this->page = $page;

        $result = $this->parse();

        return $result;
    }

    protected function parse()
    {
        $result = [];
        $tries = 0;

        while(count($result) < $this->results_count && $tries !== 5)
        {
            $links = $this->get_links();
            $last_count = count($result);
            $result[] = $this->parse_comments($links, 10);
            if(count($result) === $last_count) $tries++;
            $this->page++;
        }

        return $result;
    }

    public function get_links()//получаем ссылки для парса
    {
        $url = $this->compareUrl($this->keyword, $this->page);
        $data = $this->request($url);


        preg_match_all(static::LINK_REGEX, $data,$matches_url);//вытаскиваем ссылки из страницы
        $links = $matches_url[1];

        $links = $this->validate_links($links);

        return $links;
    }


    public function parse_comments($links, $length)//парсим конкретные ссылки
    {
        $result = '';

        foreach ($links as $link) {
            if(strlen($result) >= $length) break;

            $out = $this->request($link);
            $out = $this->validate_tags($out);
            preg_match_all('!\<p\>(.*?)\</p\>!siu', $out, $lines);//получаем весь текст в <p>
            foreach ($lines[1] as $p) //построчечно удаляем лишние символы и номера/ссылки
            {
                $p = strip_tags($p);
                $p = trim($p);
                if($p !== '' && $p !== ' ' && count(preg_split('/ /', $p)) > 2 && preg_match('/[а-яА-Я]/', $p) )
                {
                    $p = $this->validate($p);
                    $result .='. '.$p;
                }
            }
        }

        $result = $this->result_validate($result);
        return $result;
    }

    protected function validate($text)
    {
        $text = preg_replace('/((8|\+7|\+38)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}/', '', $text);
        $text = preg_replace('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', '', $text);
        $text = preg_replace('/(\S+)@([a-z0-9-]+)(\.)([a-z]{2,4})(\.?)([a-z]{0,4})+/', '', $text);
        $text = trim($text);

        return $text;
    }

    protected function validate_tags($out)
    {
        $out = str_ireplace('>', '> ', $out);
        //удаляем всё не нужное
        $out = preg_replace('!\<\s*textarea[^>]*\>.*?\</textarea\>!siu', '', $out);
        $out = preg_replace('!\<\s*style[^>]*\>.*?\</style\>!siu', '', $out);
        $out = preg_replace('!\<\s*script[^>]*\>.*?\</script\>!siu', '', $out);
        $out = preg_replace('!\<\s*head[^>]*\>.*?\</head\>!siu', '', $out);
        $out = preg_replace('!\<\s*nav[^>]*\>.*?\</nav\>!siu', '', $out);

        return $out;
    }

    protected function validate_links($links)
    {
        $links = @array_unique($links);
        unset($links[0]);

        foreach($links as $key => $link)
        {
            if(strpos($link,'.PDF') || strpos($link,'.pdf'))//проверяем не пдф ли файл по ссылки
            {
                unset($links[$key]);
                continue;
            }
            $links[$key] = trim($link);
        }

        return $links;
    }

    protected function result_validate($text)
    {
        $text = preg_replace('/(\.){2}/', '.', $text);
        $text = preg_replace('/^(\W)/', '', $text);
        $text = trim($text);

        return $text;
    }
}