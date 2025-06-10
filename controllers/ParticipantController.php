<?php

namespace app\controllers;

use app\components\AuthComponent;
use app\repositories\ParticipantRepository;
use app\services\RabbitMQService;
use yii\web\Controller;

class ParticipantController extends Controller
{
    private ParticipantRepository $participantRepository;
    private RabbitMQService $rabbitMQService;
    public function __construct(
        $id,
        $module,
        ParticipantRepository $participantRepository,
        RabbitMQService $rabbitMQService,
        $config = []
    )
    {
        $this->participantRepository = $participantRepository;
        $this->rabbitMQService = $rabbitMQService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {

    }
    public function actionView($id)
    {

    }
    public function actionCreate()
    {

    }
    public function actionUpdate($id)
    {

    }
    public function actionDelete($id)
    {

    }
    public function beforeAction($action){
        if (AuthComponent::isGuest()){
            return $this->redirect('index.php?r=site/login');
        }
        return parent::beforeAction($action);
    }
}