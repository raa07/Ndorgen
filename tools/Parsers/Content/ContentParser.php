<?php
namespace Tools\Parsers\Content;

use Tools\DuplicatesValidators\Validators\ContentDuplicatesValidator;
use Tools\Parsers\Parser;
use App\Models\Keywords;

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
        $this->page = $page + $keyword['po'.Keywords::PAGE_OFFSET_CONTENT];
        $this->length = $length;

        return $this->parse();
    }

    protected function parse()//получаем ссылки и дискрипшены по ключевику на page странице
    {
        $tries = 0;
        $parse_tries = 0;
        $result = [];
        $links_validator = new ContentDuplicatesValidator;
        $keyword_model = new Keywords();
        $next_desc = '';

        while(count($result) < $this->results_count && $parse_tries < 10)//пока не получим нужное кличество контента или пока не накапает 5 попыток
        {
            if(!empty($next_desc)) {
                $new_desc = $next_desc;
                $next_desc = '';
            }else {
                $new_desc = '';
            }

            while(mb_strlen($new_desc) < $this->length && $tries < 10) {
                $url = $this->compareUrl($this->keyword['ti'], $this->page);
                $data = $this->request($url, 10);
                if(!$data) {
                    break 1;
                }
                $links_data = [];
                $descs = [];

                foreach($data as $entity) {
                    $descs[] = $entity['snippet'];
                }
//                $descs = $links_validator->validate($links_data);
                $keyword_model->addPageOffset($this->keyword['_id'], Keywords::PAGE_OFFSET_CONTENT); //повышаем отступ в страницах парса для этого ключевика
                foreach($descs as $desc) {
                    $desc_result = $this->validate($desc);//проводим валидацию дискрипшена

                    if($desc_result) {
                        if(mb_strlen($new_desc) >= $this->length) {
                            $next_desc = $desc_result;
                            break 1;
                        }
                        $new_desc .= '.' . $desc_result;
                    }
                }
                $this->page++;
                $tries++;
            }
            if(mb_strlen($new_desc) >= $this->length) {
                if($new_desc[0] === '.') $new_desc = substr($new_desc, 1);
                $result[] = $new_desc;
            } else {
                $parse_tries++;
                break;
            }
            $tries = 0;
        }

        return $result;
    }

    protected function validate($content)//проводим валидацию контента и удаляем всё лишнее
    {
        $content = strip_tags($content);
        $content = preg_replace('/(pdf.*)$/', '', $content);
        $content = preg_replace('/(ООО ".*")/u', '', $content);
        $content = preg_replace('/(\d{2}\.\d{2}\.\d{4})/', '', $content);
        $content = preg_replace('/(\|)/', '', $content);
        $content = preg_replace('/(\…)/u', '', $content);
        $content = preg_replace('/(\.){2,}/', '', $content);
        $content = preg_replace('/[a-zA-Z\-\.0-9]*(href|url|http|www|\.ru|\.com|\.net|\.info|\.org|\.ua)/i', '', $content);
        $content = preg_replace('/^([\.,])/', '', $content);
        $content = preg_replace('/(\s.)$/u', '', $content);
        $content = trim($content);
        if(!preg_match('/([а-яА-Я])/u', $content)) {
            return false;
        }//если нету русских букв
        if(!preg_match('/( )/u', $content)) {
            return false;
        }
        if(substr_count($content, ' ') <= 2) {
            return false;
        }

        return $content;
    }
}