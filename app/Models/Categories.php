<?php

namespace App\Models;

use App\Model;

class Categories extends Model
{
    public function createCategory(string $title):bool
    {
        $link = transcriptLink($title);
        $category = [
            'ti' => $title,
            'l' => $link
        ];

        $result = $this->insert($category);

        return (bool)$result;
    }

    public function createCategories(array $categories):bool
    {
        foreach($categories as $category)
        {
            $category = trim($category);
            $data[] = [
                'ti' => $category
            ];
        }

        return $this->insertMany($data);
    }
}