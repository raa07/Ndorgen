<?php


use App\View;
use App\Models\Posts;

use Tools\Parsers\Title\RamblerTitleParser;
use Tools\Parsers\Content\RamblerContentParser;
use Tools\Parsers\Comment\RamblerCommentParser;

class PostsController
{
    public function post()
    {
        if(!isset($_REQUEST['id'])) return View::result('template1/404');
        $id = $_REQUEST['id'];
        $post =  new Posts;
        $post = $post->getPost($id);

        if(!empty($post)) return View::result('template1/post', ['post' => $post]);
        else return View::result('template1/404');
    }
}