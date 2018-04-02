<?php

namespace App;

abstract class Model extends ParentModel
{
    protected $collection_name;
    public $collection;

    public function __construct()
    {
        $db_name = Dorgen::getDomain();
        try
        {
            $cnn = new \MongoDB\Client();
            $db = $cnn->$db_name;
            $collection_name = static::$collection_name ?? static::class;
            $this->collection = $db->$collection_name;
        } catch (\Exception $exception)
        {
            die('db connect_error');
        }
    }

}