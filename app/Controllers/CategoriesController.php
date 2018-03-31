<?php


use App\View;
use App\Models\Posts;
use \App\Models\Comments;
use \App\Models\Categories;

class CategoriesController
{
    public function allCategories():bool
    {
        $categories_model = new Categories();
        $categories = $categories_model->all();

        return View::result('template1/categories', ['categories' => $categories]);
    }
}