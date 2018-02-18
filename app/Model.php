<?php

namespace App;

abstract class Model
{
    private $collection_name;
    public $collection;

    function __construct()
    {
        $db_name = Dorgen::getDomain();
        $cnn = new \MongoDB\Client();
        $db = $cnn->$db_name;
        $collection_name = static::$collection_name ?? static::class;
        $this->collection = $db->$collection_name;
    }

    public function all()
    {
        return $this->collection->find();
    }

    protected function insert(array $data):bool
    {
        $result = (bool) $this->collection->insertOne($data);
        return $result;
    }
}