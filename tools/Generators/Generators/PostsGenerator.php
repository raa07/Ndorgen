<?php

namespace Tools\Generators\Generators;

use App\Models\Keywords;
use App\Models\Posts;
use Tools\Generators\Generator;
use Tools\Generators\GeneratorInterface;

class PostsGenerator extends Generator implements GeneratorInterface
{
    public function generateElements($result_count, $length):array
    {
        $result = [];

        for($i=0; $i < $result_count; $i++)
        {
            $result[] = $this->generateElement($length);
        }

        return $result;
    }

    protected function generateElement($length):bool
    {
        $keyword = new Keywords();
        $keyword = ['cid' => 1, 'id' => 1];///////
        $category_id = $keyword['cid'];
        $category_name = $keyword['cn'];
        $keyword_id = $keyword['_id'];

        $title = 'title';//////////////
        $text = 'text'; ///////////////
        $author = new stdClass();///////////
        $post = new Posts;
        $result = $post->createPost($title, $text, $category_id, $category_name,  $keyword_id, $author);

        if($result) $keyword->addPost($keyword_id);

        return (bool)$result;
    }
}