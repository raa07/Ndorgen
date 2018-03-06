<?php


use App\View;
use App\Models\Posts;

use Tools\Parsers\Title\RamblerTitleParser;
use Tools\Parsers\Content\RamblerContentParser;
use Tools\Parsers\Comment\RamblerCommentParser;

class MainController
{
    public function index()
    {
        $posts = new Posts;
        $posts = $posts->all();

//        $test = new RamblerTitleParser;
//        var_dump($test->run('test', 10, 1));
//
//        $test2 = new RamblerContentParser;
//        var_dump($test2->run('test', 10, 1));

//        $test3 = new RamblerCommentParser;
//        var_dump($test3->run('machine learning', 10, 1));



        return View::result('template1/index', ['posts' => $posts]);
    }

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