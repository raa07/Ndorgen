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
        $db_name = $this->db_name ?? 'NDorgenSettings';
        $cnn = new \MongoDB\Client();
        $this->conn = $cnn->$db_name;
        $collection_name = $this->collection_name ?? static::class;
        $this->collection = $this->conn->$collection_name;
    }


}