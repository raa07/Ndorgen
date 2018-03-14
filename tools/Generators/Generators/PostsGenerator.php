<?php

namespace Tools\Generators\Generators;

use App\Models\Keywords;
use App\Models\Posts;
use App\Models\Users;
use Tools\Generators\Generator;
use Tools\Generators\GeneratorInterface;
use Tools\Parsers\Content\BingContentParser;
use Tools\Parsers\Title\BingTitleParser;

class PostsGenerator extends Generator implements GeneratorInterface
{
    public function generateElements($result_count):array
    {
        $result = [];

        for($i=0; $i < $result_count; $i++)
        {
            $result[] = $this->generateElement();
        }

        return $result;
    }

    protected function generateElement():bool
    {
        $result = false;

        $keyword_model = new Keywords();
        $keyword = $keyword_model->getUnused();///////
        $category_id = $keyword['cid'];
        $category_name = $keyword['cti'];
        $keyword_id = $keyword['_id'];
        $keyword_name = $keyword['ti'];

        $title_parser = new BingTitleParser();
        $title_parser = $title_parser->run($keyword_name, 1);
        $title = $title_parser[0];
        $title = empty($title) ? 'error' : $title;


        $content_parser = new BingContentParser();
        $content_parser = $content_parser->run($keyword_name, 1);
        $content = reset($content_parser);
        $content = empty($content) ? 'error' : $content;

        $author_model = new Users;
        $author = $author_model->getUnused();
        $author = iterator_to_array($author);
        $author_id = $author['_id'];
        unset($author['_id']);

        $post = new Posts;
        $result = $post->createPost($title, $content, $category_id, $category_name, (string)$keyword_id, $author);

        if($result) {
            $keyword_model->addPost($keyword_id);
            $author_model->addPost($author_id);
        }

        return (bool)$result;
    }
}