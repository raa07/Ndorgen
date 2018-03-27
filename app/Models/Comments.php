<?php

namespace App\Models;

use App\Model;

class Comments extends Model
{
    public function create(string $text,
       string $pid,
       array $author):bool
    {
        $date = date('F j, Y');

        $comment = [
            'tx' => $text,
            'pid' => $pid,
            'd' => $date,
            'a' => $author
        ];

        return $this->insert($comment);
    }

    public function getPostsComments($post_id)
    {
        $post_id = (string) $post_id;

        return $this->collection->find(['pid' => $post_id]);
    }
}