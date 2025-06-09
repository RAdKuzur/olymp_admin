<?php

namespace app\components;

use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class DataProviderHelper
{
    public static function createArrayDataProvider($model){
        return new ArrayDataProvider([
            'allModels' => $model,
        ]);
    }
    public static function createActiveDataProvider($query){
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}