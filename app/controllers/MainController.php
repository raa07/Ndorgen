<?php

require_once(__DIR__ .'/../../app/models/Posts.php');

use App\View;

class MainController
{
    public function index()
    {
        $posts = new Posts;
        $posts = $posts->all();

        View::result('template1/index', ['posts' => $posts]);
    }
}