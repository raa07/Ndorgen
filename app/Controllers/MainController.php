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

        return $this->test();

        return View::result('template1/index', ['posts' => $posts]);
    }

    public function test()
    {

//        $test = new RamblerTitleParser;
//        var_dump($test->run('кросовки', 31, 1));
//
//        $test2 = new RamblerContentParser;
//        var_dump($test2->run('test test', 20, 1));

//        $test3 = new RamblerCommentParser;
//        var_dump($test3->run('machine learning', 2, 1));

        $keyword = new \App\Models\Keywords();
//        //$keyword->createKeyword('test keyword', '0', 'test category');
        $unusedKeyword = $keyword->getUnused();
        $keyword->addPost($unusedKeyword['_id']);
//        var_dump($unusedKeyword);



//        $url = 'https://api.vk.com/method/users.get.json?v=5.52&lang=ru&user_ids=58805346&name_case=nom&fields=city,country,status,photo_100';
//        $proxy = '139.255.57.32:8080';
////        $proxyauth = 'user:password';
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);         // URL for CURL call
//        curl_setopt($ch, CURLOPT_PROXY, $proxy);     // PROXY details with port
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Do not outputting it out directly on screen.
//        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);
//
//        $curl_scraped_page = curl_exec($ch);
//        curl_close($ch);
//
//        echo $curl_scraped_page;
    }
}