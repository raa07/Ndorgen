<?php

namespace App\Models;

use App\Model;
use \MongoDB\BSON\ObjectID;

class Users extends Model
{
    public function createUser(string $name):bool
    {
        $date = date("F j, Y");
        $user = [
            'n' => $name,
            'pc' => 0,
            'd' => $date,
            'r' => 0
        ];
        $result = $this->insert($user);

        return (bool)$result;
    }

    public function getUnused()
    {
        $filter  = [];
        $options = ['sort' => ['pc' => 1]];

        $author = $this->collection->findOne($filter, $options);
        $author = isset($author['_id']) ? $author : [];

        return $author;
    }

    public function addPost(ObjectID $id)
    {
        $this->collection->updateOne(
            ['_id' => $id],
            ['$inc' => ['pc' => 1]]
        );
    }
}