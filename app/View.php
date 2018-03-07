<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 12.02.18
 * Time: 0:03
 */

namespace App;


class View
{
    public static function result($name, $vars=[])	//отдаём шаблон по его пути !БЕЗ .PHP! и распаковуюем переданные переменные из ассоциативного массива
    {
        $path = __DIR__ ."/../templates/$name.php";
        if (file_exists($path)) {
            extract($vars);
            require ($path);
            return true;
        }
        else if($name === '404') die('error');
        else return View::result('404');
    }
}