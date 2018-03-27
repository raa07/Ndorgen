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

    public function createCategories(array $categories):bool
    {
        foreach($categories as $category)
        {
            $data[] = [
                'ti' => $category
            ];
        }

        return $this->insertMany($data);
    }
}