<?php


use App\View;
use App\Models\Posts;

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
        echo '<pre>';
//        $links_array = ['https://geektimes.ru/all/', 'https://www.instagram.com/'];
//        $links = new \App\GlobalModels\Links(\App\GlobalModels\Links::$POST_PREFIX);
//        $links->addLink('https://www.instagram.com/');
//        var_dump($links->checkLink($links_array));



//        $demon1 = new Demons\ScheduleDemon();
//        $demon1->run();


//        $keyword = new \App\Models\Keywords();
//        $keyword->postNeed();

//        $demon1->createTask([10, 15], 1, 'localhost');

//        $category = new \App\GlobalModels\Categories();
////        $category->createCategory('тестовая категория');
//        $category_id = iterator_to_array($category->all())[0]['_id'];
//
//        $dorgen = new \App\GlobalModels\Dorgens();
//        $dorgen->createDorgen(Dorgen()->getDomain(), $category_id);


//        $demon2 = new \Demons\GeneratorDemon();
//        $demon2->run();

//        $test = new Tools\Parsers\Title\BingTitleParser;
//        var_dump($test->run('кроссовки', 10, 300));

//        $test2 = new Tools\Parsers\Content\BingContentParser;
//        var_dump($test2->run('кроссовки', 11, 300));

//        $test3 = new Tools\Parsers\Comment\BingCommentParser;
//        var_dump($test3->run('кроссовки', 5, 100));

//        $test4 = new \Tools\Parsers\User\VkUserParser();
//        var_dump($test4->run(40));

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
//
//        $generator = new \Tools\Generators\Generators\PostsGenerator();
//        $generator->generateElements(50);//

//        $generator = new \Tools\Generators\Generators\UsersGenerator();
//        $generator->generateElements(5);

//        $generator_comments = new \Tools\Generators\Generators\CommentsGenerator();
//        $generator_comments->generateElements(2, 300, 2);
        echo '</pre>';

    }
}