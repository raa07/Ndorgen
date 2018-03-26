<?php

namespace App\GlobalModels;

use App\GlobalModel;
use App\Models\Keywords;
use App\Models\Posts;
use App\Models\Users;

class Dorgens extends GlobalModel
{
    private $dorgen;

    public function __construct($dorgen = false)
    {
        $this->dorgen = $dorgen;
        parent::__construct();
    }

    public function createDorgen($name, $cid, $csid)
    {
        $dorgen = [
            'n' => $name,
            'cid' => $cid,
            'csid' => $csid
        ];

        $result = $this->insert($dorgen);

        return $result;
    }

    public function getCategoryByHost($host)
    {
        $dorgen = $this->findOne('n', $host);

        return !isset($dorgen['csid']) ? false : $dorgen['csid'];
    }

    public function getAll()
    {
        $dorgens_db = $this->all();

        foreach($dorgens_db as $dorgen) {
            $result[] = new Dorgens($dorgen);
        }

        return $result;
    }

    public function needPosts()
    {
        if(!isset($this->dorgen['_id'])) return false;
        Dorgen()->setDomain($this->dorgen['n']);
        $keyword_model = new Keywords;
        $result = $keyword_model->postNeed();

        return $result;
    }

    public function needComments()
    {
        if(!isset($this->dorgen['_id'])) return false;
        Dorgen()->setDomain($this->dorgen['n']);
        $post_model = new Posts();
        $result = $post_model->commentNeed();

        return $result;
    }

    public function needUsers()
    {
        if(!isset($this->dorgen['_id'])) return false;
        Dorgen()->setDomain($this->dorgen['n']);
        $user_model = new Users();
        $result = $user_model->userNeed();

        return $result;
    }

    public function getName()
    {
        return $this->dorgen['n'] ?? '';
    }
}