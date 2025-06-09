<?php

namespace app\controllers;

use app\components\AuthComponent;
use yii\web\Controller;

class UserController extends Controller
{
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