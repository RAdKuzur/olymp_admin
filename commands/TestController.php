<?php

namespace app\commands;

use app\components\helpers\RabbitMQHelper;
use app\services\RabbitMQService;
use Yii;
use yii\console\Controller;

class TestController extends Controller
{
    private RabbitMQService $rabbitMQService;
    public function __construct(
        $id,
        $module,
        RabbitMQService $rabbitMQService,
        $config = []
    )
    {
        $this->rabbitMQService = $rabbitMQService;
        parent::__construct($id, $module, $config);
    }

    public function actionCreateUser(){
        $this->rabbitMQService->publish(
            [RabbitMQHelper::AUTH_QUEUE_NAME],
            Yii::$app->params['serviceName'],
            RabbitMQHelper::CREATE,
            RabbitMQHelper::USER_TABLE,
            [
                'email' => 'test@test.com',
                'password' => '$2y$13$93wnmnGWT1ADlkabnFXnheGvfDamiOHzjwCCHdjZ1f44mfD3oUcD6',
            ]
        );
    }
    public function actionDeleteUser(){
        $this->rabbitMQService->publish(
            [RabbitMQHelper::AUTH_QUEUE_NAME],
            Yii::$app->params['serviceName'],
            RabbitMQHelper::DELETE,
            RabbitMQHelper::USER_TABLE,
            [],
            [
                'email' => 'test@test.com'
            ]
        );
    }
    public function actionUpdateUser(){
        $this->rabbitMQService->publish(
            [RabbitMQHelper::AUTH_QUEUE_NAME],
            Yii::$app->params['serviceName'],
            RabbitMQHelper::UPDATE,
            RabbitMQHelper::USER_TABLE,
            [
                'email' => 'admin@admin.com'
            ],
            [
                'email' => 'test@test.com'
            ]
        );
    }
}