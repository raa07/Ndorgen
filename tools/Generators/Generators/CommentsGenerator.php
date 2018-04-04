<?php

namespace Tools\Generators\Generators;

use App\Models\Comments;
use App\Models\Keywords;
use Tools\Generators\Generator;
use App\Models\Posts;
use App\Models\Users;
use Tools\Generators\GeneratorInterface;
use Tools\Parsers\Comment\BingCommentParser;
use App\Config;


class CommentsGenerator extends Generator implements GeneratorInterface
{
    protected $keyword_model;

    public function generateElements($result_count, $comments_for_post):array
    {
        $result = [];
        $this->keyword_model = new Keywords();

        for($i=0; $i < $result_count; $i++)
        {
            $result[] = $this->generateElement(Config::get('generators')['comment_length'], $comments_for_post);
        }

        return $result;
    }

    protected function generateElement($length, $comments_for_post):bool
    {
        $result = false;
        $post_model = new Posts;
        $post = $post_model->getNotUpdated();

        $comments_model = new Comments();

        if(!isset($post['_id'])) {
            return false;
        }

        $post_id = $post['_id'];
        $keyword = $this->keyword_model->getById($post['kid']);
        if(null === $keyword) {
            return false;
        }

        $comments_parser = new BingCommentParser;
        $comments = $comments_parser->run($keyword, $comments_for_post, $length);

        foreach($comments as $comment) {
            $author_model = new Users;
            $author = $author_model->getLazy();
            $author = iterator_to_array($author);
            $author_id = $author['_id'];

            $new_result = $comments_model->create($comment, $post_id, $author);

            if($new_result) {
                $post_model->addComment($post_id);
                $author_model->addComment($author_id);
                $GLOBALS['tries'] = 0;
            }

            $result = $new_result && $result;
        }

        return $result;
    }

}