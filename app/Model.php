<?php

namespace App;

abstract class Model extends ParentModel
{
    protected $collection_name;
    public $collection;

    function __construct()
    {
        $db_name = Dorgen::getDomain();
        $cnn = new \MongoDB\Client();
        $db = $cnn->$db_name;
        $collection_name = static::$collection_name ?? static::class;
        $this->collection = $db->$collection_name;
    }

}