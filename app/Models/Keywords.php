<?php

namespace App\Models;

use App\Model;
use \MongoDB\BSON\ObjectID;

class Keywords extends Model
{
    public function createKeyword(
        string $title,
        string $category_id,
        string $category_title):bool
    {
        $keyword = [
            'ti' => $title,
            'cid' => $category_id,
            'cti' => $category_title,
            'pc' => 0 //post count
        ];

        $result = $this->insert($keyword);

        return (bool)$result;
    }

    // получение кейворда с меньшим количеством постов
    public function getUnused()
    {
        $filter  = [];
        $options = ['sort' => ['pc' => 1]];

        $keyword = $this->collection->findOne($filter, $options);
        $keyword = isset($keyword['_id']) ? $keyword : [];

        return $keyword;
    }

    public function addPost(ObjectID $id)
    {
        $this->collection->updateOne(
            ['_id' => $id],
            ['$inc' => ['pc' => 1]]
        );
    }
}