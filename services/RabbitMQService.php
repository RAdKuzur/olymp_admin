<?php

namespace app\services;

use app\components\helpers\RabbitMQHelper;
use Yii;

class RabbitMQService
{
    public function publish($queueName, $appName,  $method, $table, $attributes){
        $data = json_encode([
            'appName' => $appName,
            'method' => $method,
            'table' => $table,
            'attributes' => $attributes,
        ]);
        Yii::$app->rabbitmq->publish($queueName, $data);
    }
    public function consume($queueName = RabbitMQHelper::RESULT_SERVICE){
        $data = [];
        Yii::$app->rabbitmq->consume($queueName, function ($message) use (&$data) {
            $data[] = json_decode($message);
            return $message;
        }, true);
        return $data;
    }
}