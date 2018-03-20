<?php

namespace App\GlobalModels;

use App\GlobalModel;

class Categories extends GlobalModel
{
    public function createCategory($name)
    {
        $dorgen = [
            'n' => $name
        ];

        $result = $this->insert($dorgen);

        return $result;
    }

}