<?php

namespace App;

abstract class GlobalModel extends ParentModel
{
    protected $collection_name;
    protected $db_name;
    public $collection;
    protected $conn;

    function __construct()
    {
        $db_name = $this->db_name ?? Config::get('db')['settings_db'];
        try
        {
            $cnn = new \MongoDB\Client();
            $this->conn = $cnn->$db_name;
            $collection_name = $this->collection_name ?? static::class;
            $this->collection = $this->conn->$collection_name;
        } catch (\Exception $exception)
        {
            die('db connect_error');
        }
    }
}