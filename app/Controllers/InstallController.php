<?php


use App\View;
use App\Models\Posts;

use Tools\Parsers\Title\BingTitleParser;
use Tools\Parsers\Content\BingContentParser;
use Tools\Parsers\Comment\BingCommentParser;
use \App\GlobalModels\Dorgens;

class InstallController
{
    public function first_step()
    {
        $dorgen_name = $_REQUEST['dorgen_name'];
        $category = $_REQUEST['category'];

//        $dorgen = new Dorgens();
//        $dorgen->createDorgen($dorgen_name, $category);

//        $category = new \App\GlobalModels\Categories();
////        $category->createCategory('тестовая категория');
//        $category_id = iterator_to_array($category->all())[0]['_id'];
//
//        $dorgen = new \App\GlobalModels\Dorgens();
//        $dorgen->createDorgen(Dorgen()->getDomain(), $category_id);
        //todo: тут реализовать потом
    }
}