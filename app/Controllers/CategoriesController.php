<?php


use App\View;
use App\Models\Posts;
use \App\Models\Comments;
use \App\Models\Categories;

class CategoriesController
{
    public function allCategories(): bool
    {
        $categories_model = new Categories();
        $categories = $categories_model->all();

        return View::result('template1/categories', ['categories' => $categories]);
    }

    public function category()
    {
        if (!isset($_REQUEST['id'])) {
            return View::result('404');
        }
        $link = $_REQUEST['id'];
        $current_page = (int)isset($_GET['page']) ? $_GET['page'] : 1;
        $posts_model = new Posts;
        $posts = $posts_model->getPostsByCategoryLink($link, $current_page);
        $pages_count = $posts_model->getPagesCount();
        $category_link = $_REQUEST['id'];

        $data = ['posts' => $posts,
            'pages_count' => $pages_count,
            'current_page' => $current_page,
            'category_link' => $category_link];

        return View::result('template1/index', $data);
    }
}