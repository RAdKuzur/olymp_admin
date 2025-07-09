<?php

namespace app\services;

use app\models\School;

class SchoolService
{
    public function transform($data)
    {
        $json = $data['content'];
        $data = json_decode($json, true);
        $models = [];
        foreach ($data['data'] as $item) {
            $model = new School();
            $model->id = $item['id'];
            $model->name = $item['name'];
            $model->region = $item['region'];
            $models[] = $model;
        }
        return $models;
    }
    public function transformModel($data)
    {
        $json = $data['content'];
        $item = json_decode($json, true)['data'];
        $model = new School();
        $model->id = $item['id'];
        $model->name = $item['name'];
        $model->region = $item['region'];
        return $model;
    }
}