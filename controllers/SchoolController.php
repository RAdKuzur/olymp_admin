<?php

namespace app\controllers;

use app\components\AuthComponent;
use app\components\DataProviderHelper;
use app\components\helpers\RabbitMQHelper;
use app\models\School;
use app\repositories\SchoolRepository;
use app\services\RabbitMQService;
use app\services\SchoolService;
use Yii;
use yii\web\Controller;

class SchoolController extends Controller
{
    private SchoolRepository $schoolRepository;
    private RabbitMQService $rabbitMQService;
    private SchoolService $schoolService;
    public function __construct(
        $id,
        $module,
        SchoolRepository $schoolRepository,
        RabbitMQService $rabbitMQService,
        SchoolService $schoolService,
        $config = []
    )
    {
        $this->schoolRepository = $schoolRepository;
        $this->rabbitMQService = $rabbitMQService;
        $this->schoolService = $schoolService;
        parent::__construct($id, $module, $config);
    }
    public function actionIndex($page = 1){
        $schoolsJson = $this->schoolRepository->getByApiAll();
        $schools = $this->schoolService->transform($schoolsJson);
        return $this->render('index', ['schools' => DataProviderHelper::createArrayDataProvider($schools)]);
    }
    public function actionView($id)
    {
        $modelJson = $this->schoolRepository->getByApiId($id);
        $model = $this->schoolService->transformModel($modelJson);
        return $this->render('view', ['model' => $model]);
    }
    public function actionCreate(){
        $model = new School();
        if($model->load(Yii::$app->request->post())){
            $this->schoolRepository->save($model);
            $this->rabbitMQService->publish(
                [RabbitMQHelper::AUTH_QUEUE_NAME],
                Yii::$app->params['serviceName'],
                RabbitMQHelper::CREATE,
                RabbitMQHelper::SCHOOL_TABLE,
                array_diff_key($model->getAttributes(), ['id' => null]),
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', ['model' => $model]);
    }
    public function actionUpdate($id){
        $modelJson = $this->schoolRepository->getByApiId($id);
        $model = $this->schoolService->transformModel($modelJson);
        if($model->load(Yii::$app->request->post())){
            $this->schoolRepository->save($model);
            $this->rabbitMQService->publish(
                [RabbitMQHelper::AUTH_QUEUE_NAME],
                Yii::$app->params['serviceName'],
                RabbitMQHelper::UPDATE,
                RabbitMQHelper::SCHOOL_TABLE,
                array_diff_key($model->getAttributes(), ['id' => null]),
                ['id' => $id]
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model]);
    }
    public function actionDelete($id){
        $model = $this->schoolRepository->get($id);
        $this->schoolRepository->delete($model);
        $this->rabbitMQService->publish(
            [RabbitMQHelper::AUTH_QUEUE_NAME],
            Yii::$app->params['serviceName'],
            RabbitMQHelper::DELETE,
            RabbitMQHelper::SCHOOL_TABLE,
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