<?php


use App\View;
use \App\GlobalModels\Dorgens;
use \App\Models\Categories;
use \App\Models\Keywords;
use App\Config;


class InstallController
{
    public function __construct()
    {
        if(!isset($_REQUEST['pass'])) die('security');
        if($_REQUEST['pass'] !== Config::get('general')['install_pass']) {
            die('security');
        }
        if(isset($_REQUEST['dor_name'])){
            Dorgen()->setDomain($_REQUEST['dor_name']);
        }
    }

    public function createCategoryView()
    {
        return View::result('admin/category_create');
    }

    public function createCategory()
    {
        $category_name = $_REQUEST['category'];

        $category = new \App\GlobalModels\Categories();

        return $category->createCategory($category_name);
    }

    public function firstStepView()
    {
        $categories = new \App\GlobalModels\Categories();
        $categories = $categories->all();
        return View::result('admin/first_step', ['categories' => $categories]);
    }

    public function firstStep()
    {
        $dor_name = $_REQUEST['dor_name'];
        $dor_host = $_REQUEST['dor_host'];
        $category_id = $_REQUEST['category_id'];
        $dor = new Dorgens();
        $dor_result = $dor->installDorgen($dor_name, $dor_host, $category_id);

        if($dor_result) {
            return $this->secondStepView();
        }
        redirect('install/first-step');
    }

    public function secondStepView()
    {
        return View::result('admin/second_step');
    }

    public function secondStep()
    {
        $posts_categories_string = $_REQUEST['categories'] ?? '';
        $posts_categories = explode(',', $posts_categories_string);
        if(empty($posts_categories)) {
            return View::result('404');
        }
        $categories_model = new Categories();
        $result =  $categories_model->createCategories($posts_categories);

        if(!$result) return redirect('admin/second-step');
        return $this->thirdStepView();
    }

    public function thirdStepView()
    {
        return View::result('admin/third_step');
    }

    public function thirdStep()
    {
        $keywords_string = $_REQUEST['keywords'] ?? '';
        $keywords = explode(',', $keywords_string);
        if(empty($keywords)) {
            return View::result('404');
        }
        $keywords_model = new Keywords();
        $result = $keywords_model->createKeywords($keywords);
        if($result) {
            return redirect('admin/done');
        } else {
            return redirect('');
        }
    }
}