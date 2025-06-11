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
            [RabbitMQHelper::AUTH_QUEUE_NAME, RabbitMQHelper::QUEUE_NAME],
            Yii::$app->params['serviceName'],
            RabbitMQHelper::CREATE,
            RabbitMQHelper::USER_TABLE,
            [
                'email' => 'test@test.com',
                'password_hash' => '$2y$13$93wnmnGWT1ADlkabnFXnheGvfDamiOHzjwCCHdjZ1f44mfD3oUcD6',
                'surname' => 'test_surname',
                'firstname' => 'test_firstname',
                'patronymic' => 'test_patronymic',
                'phone_number' => 'test_phone_number',
                'gender' => 0,
                'role' => 0,
                'birthdate' => '1990-01-01',
                'active' => 1
            ]
        );
        $data = $this->rabbitMQService->consume();
        $this->rabbitMQService->message($data);
    }
    public function actionDeleteUser(){
        $this->rabbitMQService->publish(
            [RabbitMQHelper::AUTH_QUEUE_NAME, RabbitMQHelper::QUEUE_NAME],
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
            [RabbitMQHelper::AUTH_QUEUE_NAME, RabbitMQHelper::QUEUE_NAME],
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