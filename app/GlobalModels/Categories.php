<?php

namespace App\GlobalModels;

use App\GlobalModel;

class Categories extends GlobalModel
{
    public function createCategory($name, $sid)
    {
        $dorgen = [
            'n' => $name,
            'sid' => $sid
        ];

        $result = $this->insert($dorgen);

        return $result;
    }
}