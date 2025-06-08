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
            $token = $response['cookies']->getValue('token');
            if ($content->status_code == ApiHelper::STATUS_OK && isset($token)) {
                // Создаем cookie
                $cookie = new \yii\web\Cookie([
                    'name' => 'username',
                    'value' => ['email' => $model->username, 'token' => $token],
                    'httpOnly' => true,
                    'path' => '/',              // важно: общий путь
                    'expire' => time() + 86400 * 365, // срок действия - 1 год
                ]);

                // Добавляем cookie в response
                Yii::$app->response->cookies->add($cookie);

                // ВАЖНО: сначала добавляем cookie, потом делаем редирект
                $response = $this->goBack();

                // Убедимся, что cookie сохранилась в редиректе
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
