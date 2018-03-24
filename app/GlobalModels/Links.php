<?php

namespace App\GlobalModels;

use App\GlobalModel;

class Links extends GlobalModel
{
    protected $collection_name;
    protected $db_name;

    public function __construct()
    {
        $links_collection = Dorgen()->getCategorySID();
        $this->collection_name = 'Links_' . $links_collection;
        $this->db_name = 'Links';

        parent::__construct();
    }


    public function addLink($name)
    {
        $link = [
            'n' => $name
        ];

        $result = $this->insert($link);

        return $result;
    }

    public function checkLink($links)
    {
        $duplicates = $this->collection->find(['n' => ['$in' => $links]]);
        $duplicate_array = [];
        foreach($duplicates as $duplicate)
        {
            $duplicate_array[] = $duplicate['n'];
        }

        $valid_links = array_diff($links, $duplicate_array);

        return $valid_links;
    }
}