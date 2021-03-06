<?php

namespace App\Models;

use App\Model;
use \MongoDB\BSON\ObjectID;
use App\Config;

class Keywords extends Model
{
    const PAGE_OFFSET_TITLE = '_t';
    const PAGE_OFFSET_CONTENT = '_cn';
    const PAGE_OFFSET_COMMENT = '_cm';

    public function createKeyword(
        string $title,
        string $category_id,
        string $category_title):bool
    {
        $keyword = [
            'ti' => $title,
            'cid' => $category_id,
            'cti' => $category_title,
            'pc' => 0, //post count,
            'po_t' => 0, //page offset titles
            'po_cn' => 0, //page offset content
            'po_cm' => 0, //page offset comments
        ];

        return $this->insert($keyword);
    }

    // получение кейворда с меньшим количеством постов
    public function getUnused()
    {
        $post_count = Config::get('generators')['posts_per_keyword'];
        $page_count = Config::get('generators')['posts_page_max'];
        $filter  = ['pc' => ['$lt' => $post_count],
            'po_t' => ['$lt' => $page_count, '$ne' => 999],
            'po_cn' => ['$lt' => $page_count, '$ne' => 999]];
        $options = ['sort' => ['pc' => 1]];

        $keyword = $this->collection->findOne($filter, $options);
        $keyword = isset($keyword['_id']) ? $keyword : [];

        return $keyword;
    }

    public function addPost(ObjectID $id)
    {
        $this->collection->updateOne(
            ['_id' => $id],
            ['$inc' => ['pc' => 1]]
        );
    }

    public function deleteFromPostGeneration(ObjectID $id)
    {
        $this->collection->updateOne(
            ['_id' => $id],
            ['$set' =>['po_t' => 999, 'po_cn' => 999]]
        );
    }

    public function addPageOffset(ObjectID $id, string $suffix)
    {
        $this->collection->updateOne(
            ['_id' => $id],
            ['$inc' => ['po'.$suffix => 1]]
        );
    }

    public function postNeed()
    {
        $post_count = Config::get('generators')['posts_per_keyword'];
        $page_count = Config::get('generators')['posts_page_max'];
        $keyword = $this->collection->findOne(
            ['pc' => ['$lt' => $post_count],
            'po_t' => ['$lt' => $page_count, '$ne' => 999],
            'po_cn' => ['$lt' => $page_count, '$ne' => 999]]);

        return isset($keyword['_id']);
    }

    public function createKeywords(array $keywords):bool
    {
        $categories = new Categories;
        $categories = $categories->all();
        $categories = iterator_to_array($categories);
        $data = [];
        foreach($keywords as $keyword)
        {
            $c_number = array_rand($categories, 1);
            $keyword = trim($keyword);
            $data[] = [
                'ti' => $keyword,
                'cid' => $categories[$c_number]['_id'],
                'cti' => $categories[$c_number]['ti'],
                'pc' => 0, //post count,
                'po_t' => 0, //page offset titles
                'po_cn' => 0, //page offset content
                'po_cm' => 0, //page offset comments
            ];
        }

        return $this->insertMany($data);
    }
}