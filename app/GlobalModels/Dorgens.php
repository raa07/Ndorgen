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

    public function installDorgen($name, $host, $cid)
    {
        $category_model = new Categories();
        $category = $category_model->getById($cid);
        if(!$category) {
            return false;
        }
        return $this->createDorgen($name, $host, $cid, $category['сsid']);
    }

    public function createDorgen($name, $host, $cid, $csid)
    {
        $dorgen = [
            'n' => $name,
            'h' => $host,
            'cid' => $cid,
            'csid' => $csid,
            'a' => 1
        ];

        return $this->insert($dorgen);
    }

    public function getDorByHost($host)
    {
        $dorgen = $this->findOne('n', $host);

        return $dorgen ?? false;
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

    public function isActive()
    {
        if(!isset($this->dorgen['_id'])) return false;
        if(!isset($this->dorgen['a'])) return false;

        return (bool)$this->dorgen['a'];
    }

    public function getName()
    {
        return $this->dorgen['n'] ?? '';
    }
}