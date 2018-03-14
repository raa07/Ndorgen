<?php


use App\View;
use App\Models\Posts;

use Tools\Parsers\Title\BingTitleParser;
use Tools\Parsers\Content\BingContentParser;
use Tools\Parsers\Comment\BingCommentParser;

class MainController
{
    public function index()
    {
        $posts = new Posts;
        $posts = $posts->all();

        return $this->test();

        return View::result('template1/index', ['posts' => $posts]);
    }

    public function test()
    {

//        $test = new BingTitleParser;
//        var_dump($test->run('кросовки', 31, 0));
//
//        $test2 = new BingContentParser;
//        var_dump($test2->run('кроссовки', 20, 0));

//        $test3 = new BingCommentParser;
//        var_dump($test3->run('кроссовки', 2, 0));

//        $test4 = new \Tools\Parsers\User\VkUserParser();
//        var_dump($test4->run(6));

//        $keyword = new \App\Models\Keywords();
//        $keyword->createKeyword('test keyword', '0', 'test category');
//        $unusedKeyword = $keyword->getUnused();
//        $keyword->addPost($unusedKeyword['_id']);
//        var_dump($unusedKeyword);

//        $user = new \App\Models\Users();
//        $user->createUser('тестовый аккаунт'.rand(10, 1000));
//        $unusedUser = $user->getUnused();
//        $user->addPost($unusedUser['_id']);
//        var_dump($unusedUser);

//        $generator = new \Tools\Generators\Generators\PostsGenerator();
//        $generator->generateElements(2);
    }
}