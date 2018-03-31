<?php

namespace App\Models;

use App\Model;

class Categories extends Model
{
    const LINK_VALID = '/[^a-z0-9\-]*/';

    public function createCategory(string $title):bool
    {
        $link = transcriptLink($title);
        $category = [
            'ti' => $title,
            'lk' => $link
        ];

        return $this->insert($category);
    }

    public function createCategories(array $categories):bool
    {
        foreach ($categories as $category) {
            $category = trim($category);
            $link = transcriptLink($category);

            $data[] = [
                'ti' => $category,
                'lk' => $link
            ];
        }

        return $this->insertMany($data);
    }

    public function getByLink(string $link)
    {
        if(!preg_match(self::LINK_VALID, $link)) {
            return [];
        }

        $category = $this->findOne('lk', $link);

        return empty($category) ? [] : $category;
    }
}