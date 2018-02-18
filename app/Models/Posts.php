<?php

namespace App\Models;

use App\Model;

class Posts extends Model
{
    public function createPost(string $title,
    string $text,
    int $category_id,
    int $keyword_id):bool
    {

        $author = Users::getAuthor();
        $link = self::generateLink($title);
        $date = date("F j, Y");

        $post = [
            'ti' => $title,
            'tx' => $text,
            'lk' => $link,
            'cid' => $category_id,
            'kid' => $keyword_id,
            'd' => $date,
            'cc' => 0,
            'a' => $author
        ];

        $result = $this->insert($post);

        return $result;
    }

    public static function generateLink(string $title):string
    {
        return '';
    }
}