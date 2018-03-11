<?php

namespace App\Models;

use App\Model;

class Categories extends Model
{
    public function createCategory(string $title):bool
    {
        $category = [
            'ti' => $title
        ];

        $result = $this->insert($category);

        return (bool)$result;
    }
}