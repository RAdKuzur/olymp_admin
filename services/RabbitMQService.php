<?php

namespace app\services;

use app\components\helpers\RabbitMQHelper;
use Yii;
use function Symfony\Component\String\b;

class RabbitMQService
{
    public function publish($queueNames, $appName,  $method, $table, $attributes, $searchAttributes = NULL){
        foreach ($queueNames as $queueName) {
            $data = json_encode([
                'appName' => $appName,
                'method' => $method,
                'data' => [
                    'table' => $table,
                    'attributes' => $attributes,
                    'searchAttributes' => $searchAttributes,
                ]
            ]);
            Yii::$app->rabbitmq->publish($queueName, $data);
        }
    }
    public function consume($queueName = RabbitMQHelper::QUEUE_NAME){
        $data = [];
        Yii::$app->rabbitmq->consume($queueName, function ($message) use (&$data) {
            $data[] = json_decode($message);
            return $message;
        }, true);
        return $data;
    }
    public function message($data){
        foreach ($data as $item){
            switch ($item->method) {
                case RabbitMQHelper::CREATE:
                    $this->create($item);
                    break;
                case RabbitMQHelper::UPDATE:
                    $this->update($item);
                    break;
                case RabbitMQHelper::DELETE:
                    $this->delete($item);
                    break;
            }
        }
    }
    public function create($item){
        $command = Yii::$app->db->createCommand();
        $command->insert($item->data->table, (array)$item->data->attributes);
        $command->execute();
    }
    public function update($item){
        $command = Yii::$app->db->createCommand();
        $command->update($item->data->table, (array)$item->data->attributes, (array)$item->data->searchAttributes);
        $command->execute();
    }
    public function delete($item){
        $command = Yii::$app->db->createCommand();
        $command->delete($item->data->table, (array)$item->data->searchAttributes);
        $command->execute();
    }
}