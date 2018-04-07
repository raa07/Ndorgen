<?php


use App\View;
use App\Models\Posts;

class MainController
{
    public function index()
    {
        $current_page = (int) isset($_GET['page']) ? $_GET['page'] : 1;
        $posts_model = new Posts;
        $posts = $posts_model->allPaginated($current_page);
        $pages_count = $posts_model->getPagesCount();
//        return $this->test();

        return View::result('template1/index', ['posts' => $posts, 'pages_count' => $pages_count, 'current_page' => $current_page]);
    }

    public function test()
    {
        echo '<pre>';

        $GLOBALS['tries'] = 0;
//        $links_array = ['https://geektimes.ru/all/', 'https://www.instagram.com/'];
//        $links = new \App\GlobalModels\Links(\App\GlobalModels\Links::$POST_PREFIX);
//        $links->addLink('https://www.instagram.com/');
//        var_dump($links->checkLink($links_array));



//            $tasks = new \App\GlobalModels\Tasks();
//            $tasks->removeById('5abf68fa29e96074163eb48a');

//            $global_category = new \App\GlobalModels\Categories();
//            $global_categories = $global_category->all();
//            foreach ($global_categories as $cat)
//            {
//                var_dump($cat);
//            }

//        $keyword_model = new \App\Models\Keywords();
//        $keyword = $keyword_model->getUnused();

//        $keyword_model->deleteFromPostGeneration($keyword['_id']);


//        $category = new \App\GlobalModels\Categories();
////        $category->createCategory('тестовая категория');
//        $category_id = iterator_to_array($category->all())[0]['_id'];
//
//        $demon1 = new Demons\ScheduleDemon();
//        $demon1->run();
//        $demon1->createTask([5, 10], 1, 'localhost');

//        $demon2 = new \Demons\GeneratorDemon();
//        $demon2->run();

//        $test = new Tools\Parsers\Title\BingTitleParser;
//        var_dump($test->run($keyword, 1, 100));

//        $test2 = new Tools\Parsers\Content\BingContentParser;
//        var_dump($test2->run($keyword, 1, 100));

//        $test3 = new Tools\Parsers\Comment\BingCommentParser;
//        var_dump($test3->run($keyword, 1, 100));

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
        $generator = new \Tools\Generators\Generators\PostsGenerator();
        $generator->generateElements(2);//

//        $generator = new \Tools\Generators\Generators\UsersGenerator();
//        var_dump($generator->generateElements(5));

//        $generator_comments = new \Tools\Generators\Generators\CommentsGenerator();
//        $generator_comments->generateElements(3, 2, 1);
        echo '</pre>';

    }

    public function aboutUs()
    {
        return View::result('template1/about_us');
    }

    public function contactUs()
    {
        return View::result('template1/contact_us');
    }
}