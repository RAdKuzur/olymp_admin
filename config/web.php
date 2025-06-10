<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '1xUDW5MiJuev31wqSp1A_0wyukIsTnIM',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '172.16.0.94',
            'port' => 6379,
            'database' => 0,
        ],
        'rabbitmq' => [
            'class' => 'app\components\RabbitMQComponent',
            'host' => '172.16.0.94',
            'port' => 5672,
            'user' => 'test',
            'password' => 'test',
            'vhost' => '/',
        ],
        'apiService' => [
            'class' => 'app\services\ApiService',
            'baseUrl' => 'http://172.16.0.94/olymp_journal/frontend/web/api',
            'timeout' => 60,
            'defaultHeaders' => [
                'Authorization' => 'Bearer your-access-token',
            ],
        ],
        'genders' => [
            'class' => 'app\components\dictionaries\GenderDictionary',
        ],
        'roles' => [
            'class' => 'app\components\dictionaries\RoleDictionary',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['172.16.0.94', '::1'],
    ];
}

return $config;
