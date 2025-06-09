<?php

namespace app\repositories;

use app\models\User;

class UserRepository
{
    public function query()
    {
        return User::find();
    }
    public function get($id)
    {
        return User::findOne($id);
    }
    public function getAll()
    {
        return User::find()->all();
    }
    public function save($model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }
    public function delete($model){
        if (!$model->delete()) {
            throw new \RuntimeException('Delete error.');
        }
    }
}