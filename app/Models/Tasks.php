<?php

namespace App\Models;

use App\Model;

class Tasks extends Model
{
    const TYPE_POST = 0;
    const TYPE_USER = 1;
    const TYPE_COMMENT = 2;

    public function createPostTask():bool
    {
        $related = [];
        $related['k'] = $this->searchRelatedKeyword();
        $related['u'] = $this->searchRelatedUser();


    }
    public function createUserTask():bool
    {
        $related = [];

    }
    public function createCommentTask():bool
    {
        $related = [];
        $related['p'] = $this->searchRelatedPost();
    }

    private function searchRelatedKeyword():string
    {
        $keyword = new Keywords();
        $keyword = $keyword->getUnused();

        return $keyword;
    }

    private function searchRelatedUser():string
    {
        $user = new Users();
        $user = $user->getAuthor();

        return $user;
    }

    private function searchRelatedPost():string
    {
        $post = new Posts();
        $post = $post->getNotUpdated();

        return $post;
    }

}