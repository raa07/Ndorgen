<?php

namespace App\Models;

use App\Model;
use \MongoDB\BSON\ObjectID;

class Posts extends Model
{
    const LINK_VALID = '/[^a-z0-9\-]*/';
    const POST_PER_PAGE = 6;

    private $pagesCount;

    public function createPost(string $title,
    string $text,
    ObjectID $category_id,
    string $category_name,
    ObjectID $keyword_id,
    string $keyword_name,
    array $author):bool
    {

        $link = self::generateLink($title);
        $date = date("F j, Y");

        $post = [
            'ti' => $title,
            'tx' => $text,
            'lk' => $link,
            'cid' => $category_id,
            'cn' => $category_name,
            'kid' => $keyword_id,
            'kn' => $keyword_name,
            'd' => $date,
            'cc' => 0,
            'a' => $author
        ];

        $result = $this->insert($post);

        return $result;
    }

    public function getPost(string $link)
    {
        if(!preg_match(self::LINK_VALID, $link)) return [];
        $post = $this->findOne('lk', $link);

        return empty($post) ? [] : $post;
    }

    public function getNotUpdated()
    {
        $filter  = [];
        $options = ['sort' => ['cc' => 1]];

        $post = $this->collection->findOne($filter, $options);
        $post = isset($post['_id']) ? $post : [];

        return $post;
    }

    public function addComment($id)
    {
        $this->collection->updateOne(
            ['_id' => $id],
            ['$inc' => ['cc' => 1]]
        );
    }

    public static function generateLink(string $title):string
    {
        $link = transcriptLink($title);
        $link .= '-'.rand(10, 99);
        return $link;
    }

    public function commentNeed()
    {
        $comment_count = 10;///////////////TODO: config
        $post = $this->collection->findOne(['cc' => ['$lt' => $comment_count]]);
        $result = isset($post['_id']);

        return $result;
    }

    public function allPaginated($page)
    {
        $page = abs($page-1);
        $offset = $page * self::POST_PER_PAGE;
        $this->pagesCount = (int) ceil($this->collection->count() / self::POST_PER_PAGE);
        return $this->collection->find([], ['limit' => self::POST_PER_PAGE, 'skip' => $offset]);
    }

    public function getPagesCount()
    {
        return $this->pagesCount ?? 0;
    }
}