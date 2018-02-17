<?php

require_once(__DIR__ .'/../app/Model.php');

abstract class Model{
    private $collection_name;

    public $collection;

    function __construct()
    {
        $db_name = Dorgen::getDomain();

        $cnn = new \MongoDB\Client();
        $db = $cnn->$db_name;

        $collection_name = static::$collection_name ?? static::class;

        $this->collection = $db->$collection_name;

        $post = [
            'ti' => 'test title lol',
            'tx' => 'Aenean consequat porttitor adipiscing. Nam pellentesque justo ut tortor congue lobortis. Donec venenatis sagittis fringilla. Etiam nec libero magna, et dictum velit. Proin mauris mauris, mattis eu elementum eget, commodo in nulla. Mauris posuere venenatis pretium. Maecenas a dui sed lorem aliquam dictum. Nunc urna leo, imperdiet eu bibendum ac, pretium ac massa. Cum sociis natoque penatibus et magnis dis parturient montes, ',
            'lk' => 'oh_no',
            'cid' => 10,
            'kid' => 'lol',
            'd' => time(),
            'cc' => 20,
            'a' => [
                'id' => 10,
                'n' => 'name author',
                'a' => 'avatar'
            ]

        ];


        $this->collection->insertOne($post);


    }

    public function all()
    {
        return $this->collection->find();
    }
}