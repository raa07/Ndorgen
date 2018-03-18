<?php

namespace Demons;

use App\GlobalModels\Tasks;

class ScheduleDemon extends Demon
{
    public function createTask(array $count_intervals, int $type, string $dorgen) : bool
    {
        $tasks = new Tasks;

        $result = $tasks->createTask($type, $count_intervals, $dorgen);

        return $result;
    }

    public function run()
    {
        $dorgens = [];
        foreach($dorgens as $dorgen) {
            if($dorgen->needPosts()) {
                $this->createTask([], Tasks::TYPE_POST, $dorgen->getName());
            }
            if($dorgen->needUsers()) {
                $this->createTask([], Tasks::TYPE_USER, $dorgen->getName());
            }
            if($dorgen->needComment()) {
                $this->createTask([], Tasks::TYPE_USER, $dorgen->getName());
            }
        }
    }

    public function stop()
    {

    }
}