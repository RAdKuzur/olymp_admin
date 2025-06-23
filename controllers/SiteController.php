<?php

namespace app\controllers;

use app\components\helpers\ApiHelper;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->params['authRequired']) {
            $response = Yii::$app->apiService->post(ApiHelper::AUTH_URL_API, [
                'email' => $model->username,
                'password' => $model->password,
            ]);
            $content = json_decode($response['content']);
            $token = $response['cookies']->getValue('refresh_token');
            if ($content->status_code == ApiHelper::STATUS_OK && isset($token)) {
                $cookie = new \yii\web\Cookie([
                    'name' => 'username',
                    'value' => ['email' => $model->username, 'token' => $token],
                    'httpOnly' => true,
                    'path' => '/',
                    'expire' => time() + 86400 * 365,
                ]);
                Yii::$app->response->cookies->add($cookie);
                $response = $this->goBack();
                if (Yii::$app->response->cookies->has('cookie_name')) {
                    return $response;
                } else {
                    Yii::error('Failed to set cookie');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка авторизации');
            }
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->response->cookies->remove('username');
        return $this->goHome();
    }
}
