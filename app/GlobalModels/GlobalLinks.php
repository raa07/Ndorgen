<?php

namespace App\GlobalModels;

use App\GlobalModel;

class GlobalLinks extends GlobalModel
{
    public function addLink($name)
    {
        $link = [
            'n' => $name
        ];

        $result = $this->insert($link);

        return $result;
    }
}