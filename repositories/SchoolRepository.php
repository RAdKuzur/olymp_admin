<?php

namespace app\repositories;

use app\models\School;

class SchoolRepository
{
    public function get($id)
    {
        return School::findOne($id);
    }
    public function getAll()
    {
        return School::find()->all();
    }
    public function query(){
        return School::find();
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