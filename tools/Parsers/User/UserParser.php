<?php

namespace Tools\Parsers\User;

//парсер юзеров
abstract class UserParser
{
    private $results_count;

    abstract protected function getUsers(int $result_count):array;

    public function run($result_count)//отдаём результат парса через эту функцию
    {
        $this->results_count = $result_count;

        $result = $this->parse();

        return $result;
    }

    protected function parse()//парсим тайтлы с page страницы
    {
        $result = [];
        $tries = 0;
        while(count($result) < $this->results_count && $tries <10)//пока не получим нужное кличество тайтлов или пока не накапает 5 попыток
        {
            $new_result = $this->getUsers($this->results_count);
            $result = array_merge($result, $new_result);
            $this->results_count = $this->results_count - count($new_result);
            if(count($result) === 0) {
                $tries++;
            }
        }

        return $result;
    }
}