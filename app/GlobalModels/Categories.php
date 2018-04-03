<?php

namespace App\GlobalModels;

use App\GlobalModel;

class Categories extends GlobalModel
{
    public function createCategory($name)
    {
        $sid = transcriptLink($name);
        $category = [
            'n' => $name,
            'sid' => $sid
        ];

        return $this->insert($category);
    }
}