<?php


use App\View;
use App\Models\Posts;

use Tools\Parsers\Title\BingTitleParser;
use Tools\Parsers\Content\BingContentParser;
use Tools\Parsers\Comment\BingCommentParser;
use \App\Models\Comments;

class PostsController
{
    public function post()
    {
        if(!isset($_REQUEST['id'])) return View::result('template1/404');
        $id = $_REQUEST['id'];
        $post =  new Posts;
        $post = $post->getPost($id);
        $comments_model = new Comments();
        $comments = $comments_model->getPostsComments($post['_id']);


        if(!empty($post)) return View::result('template1/post', ['post' => $post, 'comments' => $comments]);
        else return View::result('template1/404');
    }
}