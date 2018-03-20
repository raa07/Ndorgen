<?php

namespace App\GlobalModels;

use App\GlobalModel;

class Dorgens extends GlobalModel
{
    public function createDorgen($name, $cid)
    {
        $dorgen = [
            'n' => $name,
            'cid' => $cid
        ];

        $result = $this->insert($dorgen);

        return $result;
    }

}