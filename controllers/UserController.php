<?php

namespace app\controllers;

use app\components\AuthComponent;
use app\components\DataProviderHelper;
use app\components\helpers\RabbitMQHelper;
use app\models\User;
use app\repositories\UserRepository;
use app\services\RabbitMQService;
use Yii;
use yii\web\Controller;

class UserController extends Controller
{
    private UserRepository $userRepository;
    private RabbitMQService $rabbitMQService;
    public function __construct(
        $id,
        $module,
        UserRepository $userRepository,
        RabbitMQService $rabbitMQService,
        $config = []
    )
    {
        $this->userRepository = $userRepository;
        $this->rabbitMQService = $rabbitMQService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $users = $this->userRepository->query();
        return $this->render('index', ['users' => DataProviderHelper::createActiveDataProvider($users)]);
    }
    public function actionView($id)
    {
        $model = $this->userRepository->get($id);
        return $this->render('view', ['model' => $model]);
    }
    public function actionCreate()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $this->userRepository->save($model);
            $this->rabbitMQService->publish(
                [RabbitMQHelper::AUTH_QUEUE_NAME],
                Yii::$app->params['serviceName'],
                RabbitMQHelper::CREATE,
                RabbitMQHelper::USER_TABLE,
                array_diff_key($model->getAttributes(), ['id' => null]),
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', ['model' => $model]);
    }
    public function actionUpdate($id)
    {
        $model = $this->userRepository->get($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->userRepository->save($model);
            $this->rabbitMQService->publish(
                [RabbitMQHelper::AUTH_QUEUE_NAME],
                Yii::$app->params['serviceName'],
                RabbitMQHelper::UPDATE,
                RabbitMQHelper::USER_TABLE,
                array_diff_key($model->getAttributes(), ['id' => null]),
                ['id' => $id]
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model]);
    }
    public function actionDelete($id)
    {
        $model = $this->userRepository->get($id);
        $this->userRepository->delete($model);
        $this->rabbitMQService->publish(
            [RabbitMQHelper::AUTH_QUEUE_NAME],
            Yii::$app->params['serviceName'],
            RabbitMQHelper::DELETE,
            RabbitMQHelper::USER_TABLE,
            [],
            ['id' => $id]
        );
        return $this->redirect(['index']);
    }
    public function beforeAction($action){
        if (AuthComponent::isGuest()){
            return $this->redirect('index.php?r=site/login');
        }
        return parent::beforeAction($action);
    }
}