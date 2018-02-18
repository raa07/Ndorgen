<?php


use App\View;
use App\Models\Posts;

class MainController
{
    public function index()
    {
        $posts = new Posts;
        $posts = $posts->all();

        View::result('template1/index', ['posts' => $posts]);
    }
}