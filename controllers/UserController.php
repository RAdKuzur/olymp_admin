<?php

namespace app\controllers;

use app\components\AuthComponent;
use app\components\DataProviderHelper;
use app\components\helpers\RabbitMQHelper;
use app\models\User;
use app\repositories\UserRepository;
use app\services\RabbitMQService;
use app\services\UserService;
use Yii;
use yii\web\Controller;

class UserController extends Controller
{
    private UserRepository $userRepository;
    private RabbitMQService $rabbitMQService;
    private UserService $userService;
    public function __construct(
        $id,
        $module,
        UserRepository $userRepository,
        RabbitMQService $rabbitMQService,
        UserService $userService,
        $config = []
    )
    {
        $this->userRepository = $userRepository;
        $this->rabbitMQService = $rabbitMQService;
        $this->userService = $userService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $usersJson = $this->userRepository->getByApiAll();
        var_dump($this->userRepository->getCount());
        $users = $this->userService->transform($usersJson);
        return $this->render('index', ['users' => DataProviderHelper::createArrayDataProvider($users)]);
    }
    public function actionView($id)
    {
        $modelJson = $this->userRepository->getByApiId($id);
        $model = $this->userService->transformModel($modelJson);
        return $this->render('view', ['model' => $model]);
    }
    public function actionCreate()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $this->rabbitMQService->publish(
                [RabbitMQHelper::AUTH_QUEUE_NAME],
                Yii::$app->params['serviceName'],
                RabbitMQHelper::CREATE,
                RabbitMQHelper::USER_TABLE,
                array_diff_key($model->getAttributes(), ['id' => null]),
            );
            //$this->userRepository->save($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', ['model' => $model]);
    }
    public function actionUpdate($id)
    {
        $modelJson = $this->userRepository->getByApiId($id);
        $model = $this->userService->transformModel($modelJson);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->rabbitMQService->publish(
                [RabbitMQHelper::AUTH_QUEUE_NAME],
                Yii::$app->params['serviceName'],
                RabbitMQHelper::UPDATE,
                RabbitMQHelper::USER_TABLE,
                array_diff_key($model->getAttributes(), ['id' => null]),
                ['id' => $id]
            );
            //$this->userRepository->save($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model]);
    }
    public function actionDelete($id)
    {
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