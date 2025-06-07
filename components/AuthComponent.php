<?php

namespace app\components;

use Yii;

class AuthComponent
{
    public static function isGuest()
    {
        return (Yii::$app->request->cookies->has('usernameBack') ||
                Yii::$app->request->cookies->has('usernameFront'))  &&
            Yii::$app->params['authRequired'];
    }
}
