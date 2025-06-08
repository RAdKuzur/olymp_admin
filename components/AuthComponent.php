<?php

namespace app\components;

use Yii;

class AuthComponent
{
    public static function isGuest()
    {
        return Yii::$app->request->cookies->has('username') && Yii::$app->params['authRequired'];
    }
}
