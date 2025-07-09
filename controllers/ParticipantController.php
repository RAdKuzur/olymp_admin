<?php

namespace app\controllers;

use app\components\AuthComponent;
use app\components\DataProviderHelper;
use app\components\helpers\RabbitMQHelper;
use app\models\Participant;
use app\repositories\ParticipantRepository;
use app\repositories\SchoolRepository;
use app\repositories\UserRepository;
use app\services\ParticipantService;
use app\services\RabbitMQService;
use Yii;
use yii\web\Controller;

class ParticipantController extends Controller
{
    private ParticipantRepository $participantRepository;
    private UserRepository $userRepository;
    private SchoolRepository $schoolRepository;
    private RabbitMQService $rabbitMQService;
    private ParticipantService $participantService;
    public function __construct(
        $id,
        $module,
        ParticipantRepository $participantRepository,
        UserRepository $userRepository,
        SchoolRepository $schoolRepository,
        RabbitMQService $rabbitMQService,
        ParticipantService $participantService,
        $config = []
    )
    {
        $this->participantRepository = $participantRepository;
        $this->userRepository = $userRepository;
        $this->schoolRepository = $schoolRepository;
        $this->rabbitMQService = $rabbitMQService;
        $this->participantService = $participantService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex($page = 1)
    {
        $participantsJson = $this->participantRepository->getByApiAll($page);
        $participantsAmount = $this->participantRepository->getCount();
        $participants = $this->participantService->transform($participantsJson);
        return $this->render('index', [
            'participants' => DataProviderHelper::createArrayDataProvider($participants),
            'participantsAmount' => $participantsAmount,
        ]);
    }
    public function actionView($id)
    {
        $modelJson = $this->participantRepository->getByApiId($id);
        $model = $this->participantService->transformModel($modelJson);
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    public function actionCreate()
    {
        $model = new Participant();
        $users = $this->userRepository->getAll();
        $schools = $this->schoolRepository->getAll();
        if ($model->load(Yii::$app->request->post())) {
            $this->participantRepository->save($model);
            $this->rabbitMQService->publish(
                [RabbitMQHelper::AUTH_QUEUE_NAME],
                Yii::$app->params['serviceName'],
                RabbitMQHelper::CREATE,
                RabbitMQHelper::PARTICIPANT_TABLE,
                array_diff_key($model->getAttributes(), ['id' => null]),
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'users' => $users,
            'schools' => $schools,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = $this->participantRepository->get($id);
        $users = $this->userRepository->getAll();
        $schools = $this->schoolRepository->getAll();
        if ($model->load(Yii::$app->request->post())) {
            $this->participantRepository->save($model);
            $this->rabbitMQService->publish(
                [RabbitMQHelper::AUTH_QUEUE_NAME],
                Yii::$app->params['serviceName'],
                RabbitMQHelper::UPDATE,
                RabbitMQHelper::PARTICIPANT_TABLE,
                array_diff_key($model->getAttributes(), ['id' => null]),
                ['id' => $id]
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'users' => $users,
            'schools' => $schools,
        ]);
    }
    public function actionDelete($id)
    {
        $model = $this->participantRepository->get($id);

        $this->participantRepository->delete($model);
        $this->rabbitMQService->publish(
            [RabbitMQHelper::AUTH_QUEUE_NAME],
            Yii::$app->params['serviceName'],
            RabbitMQHelper::DELETE,
            RabbitMQHelper::PARTICIPANT_TABLE,
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