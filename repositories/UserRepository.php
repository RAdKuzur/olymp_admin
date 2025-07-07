<?php

namespace app\repositories;

use app\components\helpers\ApiHelper;
use app\models\User;
use Yii;

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
    public function getByApiAll($page = 1, $limit = 10)
    {
        return Yii::$app->apiService->get(
            ApiHelper::USER_URL_API . '?page=' . $page . '&limit=' . $limit,
            [],
            [
                'Authorization' => "Bearer ". Yii::$app->request->cookies->get('username')->value['token'],
            ]
        );
    }
    public function getByApiId($id)
    {
        return Yii::$app->apiService->get(
            ApiHelper::USER_URL_API . '/' . $id,
            [],
            [
                'Authorization' => "Bearer ". Yii::$app->request->cookies->get('username')->value['token'],
            ]
        );
    }
    public function getCount()
    {
        $response = Yii::$app->apiService->get(
            ApiHelper::USER_COUNT_URL_API,
            [],
            [
                'Authorization' => "Bearer ". Yii::$app->request->cookies->get('username')->value['token'],
            ]
        );
        return json_decode($response['content'])->data;
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