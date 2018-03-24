<?php

namespace App\GlobalModels;

use App\GlobalModel;

class Links extends GlobalModel
{
    protected $collection_name;
    protected $db_name;

    static $TITLE_PREFIX = 'Titles';
    static $CONTENT_PREFIX = 'Contents';
    static $COMMENT_PREFIX = 'Comments';

    public function __construct($prefix)
    {
        $links_collection = Dorgen()->getCategorySID();
        $this->collection_name = $prefix .'_links_' . $links_collection;
        $this->db_name = 'Links';

        parent::__construct();
    }


    public function addLinks($links)
    {
        $insert_data = [];
        foreach($links as $link) {
            $insert_data[] = [
                'n' => $link
            ];
        }

        $result = $this->insertMany($insert_data);

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