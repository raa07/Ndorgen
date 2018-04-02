<?php

namespace App\Models;

use App\Model;
use \MongoDB\BSON\ObjectID;
use App\Config;

class Users extends Model
{
    public function createUser(string $name, string $avatar):bool
    {
        $date = date("F j, Y");
        $user = [
            'n' => $name,
            'pc' => 0,
            'd' => $date,
            'a' => $avatar,
            'r' => 0,
            'cc' => 0
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

    public function getLazy()
    {
        $filter  = [];
        $options = ['sort' => ['cc' => 1]];

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

    public function addComment(ObjectID $id)
    {
        $this->collection->updateOne(
            ['_id' => $id],
            ['$inc' => ['cc' => 1]]
        );
    }

    public function userNeed():bool
    {
        $unused = $this->getUnused();
        if(empty($unused)) {
            return true;//если нету пользователей (не нашло самого неиспользуемого) - значит точно надо создать
        }
        //если есть ещё пользователи у которых меньше N постов - не создаём новых
        $users_posts_count = Config::get('generators')['posts_per_user'];
        $user = $this->collection->findOne(['pc' => ['$lt' => $users_posts_count]]);

        return isset($user['_id']);
    }
}