<?php

namespace App;

abstract class ParentModel
{
    public function all() //получение всех записей из бд
    {
        return $this->collection->find();
    }

    protected function insert(array $data):bool //вставка данных в бд
    {
        $result = (bool) $this->collection->insertOne($data);
        return $result;
    }

    protected function insertMany(array $data):bool //вставка массива данных в бд
    {
        $result = (bool) $this->collection->insertMany($data);
        return $result;
    }

    protected function findOne(string $field, string $value) //получение записи из бд по полю и его значению
    {
        $result = $this->collection->findOne([$field => $value]);
        return (bool) $result ? $result : [];
    }

    public function getById(string $id)
    {
        $id = new \MongoDB\BSON\ObjectID($id);
        return $this->collection->findOne(['_id' => $id]);
    }


}