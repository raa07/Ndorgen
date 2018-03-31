<?php

namespace Demons;

use App\GlobalModels\Dorgens;
use App\GlobalModels\Tasks;

class ScheduleDemon extends Demon
{
        public function createTask(array $count_intervals, int $type, string $dorgen) : bool
    {
        if(empty($dorgen)) return false;
        $tasks = new Tasks;

        $result = $tasks->createTask($type, $count_intervals, $dorgen);

        return $result;
    }

    public function run()
    {
        $dorgens = new Dorgens;
        $dorgens = $dorgens->getAll();
        foreach($dorgens as $dorgen) { //важно, что бы генерация юзеров проходила перед всеми остальными генерациями
            if(!$dorgen->isActive()) {
                continue;
            }
            if($dorgen->needUsers()) {
                $this->createTask([10, 15], Tasks::TYPE_USER, $dorgen->getName());
            }
            if($dorgen->needPosts()) {
                $this->createTask([2, 5], Tasks::TYPE_POST, $dorgen->getName());
            }
            if($dorgen->needComments()) {
                $this->createTask([2, 5], Tasks::TYPE_USER, $dorgen->getName());
            }
        }
    }

    public function stop()
    {

    }
}