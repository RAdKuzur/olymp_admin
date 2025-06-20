<?php

namespace app\services;

use app\models\User;

class UserService
{
    public function transform($json)
    {
        $data = json_decode($json, true);
        $models = [];
        foreach ($data as $item) {
            $model = new User();
            //transform
            $models[] = $model;
        }
        return $models;
    }
}