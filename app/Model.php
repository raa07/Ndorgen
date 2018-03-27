<?php

namespace App;

abstract class Model
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

    public function all() //получение всех записей из бд
    {
        return $this->collection->find();
    }

    protected function insert(array $data):bool //вставка данных в бд
    {
        $result = (bool) $this->collection->insertOne($data);
        return $result;
    }

    protected function findOne(string $field, string $value) //получение записи из бд по полю и его значению
    {
        $result = $this->collection->findOne([$field => $value]);
        return (bool) $result ? $result : [];
    }

    protected function insertMany(array $data):bool //вставка массива данных в бд
    {
        $result = (bool) $this->collection->insertMany($data);
        return $result;
    }
}