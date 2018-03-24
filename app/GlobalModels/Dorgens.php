<?php

namespace App\GlobalModels;

use App\GlobalModel;

class Dorgens extends GlobalModel
{
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

}