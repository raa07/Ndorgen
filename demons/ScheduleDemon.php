<?php

namespace Demons;

use App\Models\Tasks;

class ScheduleDemon extends Demon
{
    public function createTask(array $time_intervals, array $count_intervals, int $type) : bool
    {
        $tasks = new Tasks;

        if($type === Tasks::TYPE_POST) {
            return $tasks->createPostTask();
        }else if($type === Tasks::TYPE_USER) {
            return $tasks->createUserTask();
        }else if($type === Tasks::TYPE_COMMENT) {
            return $tasks->createCommentTask();
        }else return false;
    }



    public function run()
    {

    }

    public function stop()
    {

    }
}