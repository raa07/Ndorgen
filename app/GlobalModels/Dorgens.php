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

    public function installDorgen($name, $cid)
    {
        $category_model = new Categories();
        $category = $category_model->getById($cid);
        if(!$category) {
            return false;
        }
        return $this->createDorgen($name, $cid, $category['csid']);
    }

    public function createDorgen($name, $cid, $csid)
    {
        $dorgen = [
            'n' => $name,
            'cid' => $cid,
            'csid' => $csid
        ];

        return $this->insert($dorgen);
    }

    public function getCategoryByHost($host)
    {
        $dorgen = $this->findOne('n', $host);

        return $dorgen['csid'] ?? false;
    }

    public function getAll()
    {
        $dorgens_db = $this->all();
        $result = [];

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

        return $keyword_model->postNeed();
    }

    public function needComments()
    {
        if(!isset($this->dorgen['_id'])) return false;
        Dorgen()->setDomain($this->dorgen['n']);
        $post_model = new Posts();

        return $post_model->commentNeed();
    }

    public function needUsers()
    {
        if(!isset($this->dorgen['_id'])) return false;
        Dorgen()->setDomain($this->dorgen['n']);
        $user_model = new Users();

        return $user_model->userNeed();
    }

    public function getName()
    {
        return $this->dorgen['n'] ?? '';
    }
}