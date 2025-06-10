<?php

namespace app\repositories;

use app\models\Participant;

class ParticipantRepository
{
    public function get($id)
    {
        return Participant::findOne($id);
    }
    public function getAll()
    {
        return Participant::find()->all();
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