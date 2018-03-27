<?php


use App\View;
use \App\GlobalModels\Dorgens;
use \App\Models\Categories;
use \App\Models\Keywords;

class InstallController
{
    public function __construct()
    {
        if($_REQUEST['pass'] !== 'b2345jh234523b4') {
            die('security');
        }
    }

    public function createCategory()
    {
        $category_name = $_REQUEST['name'];
        $category_csid = $_REQUEST['csid'];

        $category = new \App\GlobalModels\Categories();
        $result = $category->createCategory($category_name, $category_csid);

        return $result;
    }

    public function firstStep()
    {

        $dorgen_name = $_REQUEST['dorgen_name'];
        $category_id = $_REQUEST['$category_id'];

        $dorgen = new Dorgens();
        $dorgen_result = $dorgen->installDorgen($dorgen_name, $category_id);

        return $dorgen_result;
    }

    public function secondStep()
    {
        $posts_categories_string = isset($_REQUEST['categories']) ?? '';
        $posts_categories = explode(',', $posts_categories_string);
        if(empty($posts_categories)) {
            return View::result('404');
        }
        $categories_model = new Categories();

        return $categories_model->createCategories($posts_categories);
    }

    public function thirdStep()
    {
        $keywords_string = isset($_REQUEST['keywords']) ?? '';
        $keywords = explode(',', $keywords_string);
        if(empty($keywords)) {
            return View::result('404');
        }
        $keywords_model = new Keywords();

        return $keywords_model->createKeywords($keywords);
    }

    public function done()
    {
        die('done');
    }
}