<?php

namespace Demons;

use App\GlobalModels\Dorgens;
use App\GlobalModels\Tasks;
use App\Config;

class ScheduleDemon extends Demon
{
        public function createTask(array $count_intervals, int $type, string $dorgen, $additional = []) : bool
    {
        if(empty($dorgen)) {
            return false;
        }
        $tasks = new Tasks;

        return $tasks->createTask($type, $count_intervals, $dorgen, $additional);
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
                $this->createTask(Config::get('generators')['users_count_interval'], Tasks::TYPE_USER, $dorgen->getName());
            }
            if($dorgen->needPosts()) {
                $this->createTask(Config::get('generators')['posts_count_interval'], Tasks::TYPE_POST, $dorgen->getName());
            }
            if($dorgen->needComments()) {
                $this->createTask(Config::get('generators')['comments_count_interval'], Tasks::TYPE_COMMENT, $dorgen->getName(), ['cpp' => Config::get('generators')['comments_per_post_interval']]);
            }
        }
    }

    public function stop()
    {

    }
}