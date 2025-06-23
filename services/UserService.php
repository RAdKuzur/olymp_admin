<?php

namespace app\services;

use app\models\User;

class UserService
{
    public function transform($data)
    {
        $json = $data['content'];
        $data = json_decode($json, true);
        $models = [];
        foreach ($data['data'] as $item) {
            $model = new User();
            $model->id = $item['id'];
            $model->email = $item['email'];
            $model->password = $item['password'];
            $model->firstname = $item['firstname'];
            $model->surname = $item['surname'];
            $model->patronymic = $item['patronymic'];
            $model->phone_number = $item['phone_number'];
            $model->gender = $item['gender'];
            $model->role = $item['role'];
            $model->birthdate = $item['birthdate'];
            $models[] = $model;
        }
        return $models;
    }
    public function transformModel($data)
    {
        $json = $data['content'];
        $item = json_decode($json, true)['data'];
        $model = new User();
        $model->id = $item['id'];
        $model->email = $item['email'];
        $model->password = $item['password'];
        $model->firstname = $item['firstname'];
        $model->surname = $item['surname'];
        $model->patronymic = $item['patronymic'];
        $model->phone_number = $item['phone_number'];
        $model->gender = $item['gender'];
        $model->role = $item['role'];
        $model->birthdate = $item['birthdate'];
        return $model;
    }
}