<?php

namespace Tools\Generators\Generators;

use App\Models\Comments;
use Tools\Generators\Generator;
use App\Models\Posts;
use App\Models\Users;
use Tools\Generators\GeneratorInterface;
use Tools\Parsers\Comment\BingCommentParser;


class CommentsGenerator extends Generator implements GeneratorInterface
{
    public function generateElements($result_count, $comments_for_post):array
    {
        $result = [];

        for($i=0; $i < $result_count; $i++)
        {
            $result[] = $this->generateElement(50, $comments_for_post);/////////////////////////////////
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

        $keyword_name = $post['kn'];
        $post_id = $post['_id'];

        $comments_parser = new BingCommentParser;
        $comments = $comments_parser->run($keyword_name, $comments_for_post, $length);

        foreach($comments as $comment) {
            $author_model = new Users;
            $author = $author_model->getLazy();
            $author = iterator_to_array($author);
            $author_id = $author['_id'];
            $author['_id'] = (string) $author['_id'];

            $new_result = $comments_model->create($comment, (string) $post_id, $author);

            if($new_result) {
                $post_model->addComment($post_id);
                $author_model->addComment($author_id);
            }

            $result = $new_result && $result;
        }

        return $result;
    }

}