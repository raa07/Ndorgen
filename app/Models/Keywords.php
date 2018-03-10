<?php

namespace App\Models;

use App\Model;

class Keywords extends Model
{
    public function getUnused()
    {
        //TODO: сделать получение последнего неиспользуемого кейворда
        return 'id';
    }
}