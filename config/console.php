<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
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
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
    // configuration adjustments for 'dev' environment
    // requires version `2.1.21` of yii2-debug module
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
