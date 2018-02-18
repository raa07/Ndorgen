<?php

namespace App\Models;

use App\Model;

class Users extends Model
{

    public static function getAuthor():array
    {
        return [
            'id' => 10,
            'n' => 'name author',
            'a' => 'avatar'
        ];
    }
}