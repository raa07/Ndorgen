<?php

namespace App\Models;

use App\Model;
use \MongoDB\BSON\ObjectID;
use App\Config;

class Posts extends Model
{
    const LINK_VALID = '/[^a-z0-9\-]*/';

    private $pagesCount;
    private static $posts_per_page;

    public function __construct()
    {
        self::$posts_per_page = Config::get('generators')['posts_per_page'];
        parent::__construct();
    }

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

    public function getPostsByCategoryLink(string $link, int $page)
    {
        $category_model = new Categories();
        $category = $category_model->getByLink($link);
        if(empty($category)) {
            return [];
        }

        $page = abs($page-1);
        $offset = $page * self::$posts_per_page;
        $this->pagesCount = (int) ceil($this->collection->count(['cid' => $category['_id']]) / self::$posts_per_page);
        $posts = $this->collection->find(['cid' => $category['_id']], ['limit' => self::$posts_per_page, 'skip' => $offset, 'sort' => ['d' => -1]]);

        return $posts ?? [];
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
        $link .= '-' . rand(10, 99);
        return $link;
    }

    public function commentNeed():bool
    {
        $comment_count = Config::get('generators')['comments_per_post'];
        $post = $this->collection->findOne(['cc' => ['$lt' => $comment_count]]);

        return isset($post['_id']);
    }

    public function allPaginated($page)
    {
        $page = abs($page-1);
        $offset = $page * self::$posts_per_page;
        $this->pagesCount = (int) ceil($this->collection->count() / self::$posts_per_page);

        return $this->collection->find([], ['limit' => self::$posts_per_page, 'skip' => $offset, 'sort' => ['d' => -1]]);
    }

    public function getPagesCount():int
    {
        return $this->pagesCount ?? 0;
    }
}