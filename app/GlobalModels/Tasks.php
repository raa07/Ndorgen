<?php

namespace App\GlobalModels;

use App\GlobalModel;

class Tasks extends GlobalModel
{
    const TYPE_POST = 0;
    const TYPE_USER = 1;
    const TYPE_COMMENT = 2;

    public function createTask($type, $count_intervals, $dorgen, $additional=[])
    {
        $task = [
            't' => $type,
            'cs' => $count_intervals[0],
            'ce' => $count_intervals[1],
            'dor' => $dorgen,
            'da' => time(),
            'a' => $additional
        ];

        return $this->insert($task);
    }

}