<?php


use App\View;
use App\Models\Posts;
use Tools\Parsers\Titles\TitleRambler;
use Tools\Parsers\Content\ContentRambler;

class MainController
{
    public function index()
    {
        $posts = new Posts;
        $posts = $posts->all();

//        $test = new TitleRambler(100, 'test');
//        var_dump($test->run());

//        $test2 = new ContentRambler;
//        var_dump($test2->parse_links_desc('test'));



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