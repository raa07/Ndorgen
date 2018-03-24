<?php

namespace App;

abstract class GlobalModel
{
    protected $collection_name;
    protected $db_name;
    public $collection;

    function __construct()
    {
        $db_name = $this->db_name ?? 'NDorgenSettings';
        $cnn = new \MongoDB\Client();
        $db = $cnn->$db_name;
        $collection_name = $this->collection_name ?? static::class;
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
}