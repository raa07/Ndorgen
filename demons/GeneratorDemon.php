<?php

namespace Demons;

use App\GlobalModels\Tasks;
use Tools\Generators\Generators\CommentsGenerator;
use Tools\Generators\Generators\PostsGenerator;
use Tools\Generators\Generators\UsersGenerator;

class GeneratorDemon extends Demon
{
    private $posts_generator;
    private $comments_generator;
    private $users_generator;

    public function __construct()
    {
        $this->posts_generator = new PostsGenerator;
        $this->comments_generator = new CommentsGenerator;
        $this->users_generator = new UsersGenerator;
    }

    public function doTask($task) : array
    {
        $count_start = $task['cs'];
        $count_end = $task['ce'];
        $result_count = rand($count_start, $count_end);

        switch($task['t']) {
            case Tasks::TYPE_POST:
                return $this->posts_generator->generateElements($result_count);
            case Tasks::TYPE_COMMENT:
                $cpp_arr = $task['a']['cpp'];
                $comments_per_post = rand($cpp_arr[0], $cpp_arr[1]);
                return $this->comments_generator->generateElements($result_count, $comments_per_post);
            case Tasks::TYPE_USER:
                return $this->users_generator->generateElements($result_count);
            default: return [false];
        }
    }

    public function run()
    {
        $GLOBALS['tries'] = 0;
        $tasks_model = new Tasks;
        $tasks = $tasks_model->all();
        foreach($tasks as $task) {
            Dorgen()->setDomain($task['dor']);
            $this->doTask($task);
            $tasks_model->removeById($task['_id']);
        }
    }

    public function stop()
    {

    }
}