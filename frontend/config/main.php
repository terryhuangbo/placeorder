<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => '/redeem/home/index',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        //积分兑换
        'redeem' => [
            'class' => 'frontend\modules\redeem\Module',
        ],
        //积分兑换
        'common' => [
            'class' => 'frontend\modules\common\Module',
        ],

    ],
    'components' => [
        'db' => require(__DIR__ . '/../../common/config/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                "<module:\w+>/<controller:\w+>/<action:\D+>" => "<module>/<controller>/<action>",
                "<controller:\w+>/<action:\w+>/<id:\d+>" => "redeem/<controller>/<action>",
                "<controller:\w+>/<action:\w+>" => "redeem/<controller>/<action>",
            ],
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'jssdk' => [
            'class' => 'frontend\components\Wechat\Jssdk',
        ],
        'userData' => [
            'class' => 'app\modules\user\models\UserData',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules',
                ],
            ],
        ],
        'wechat' => [
            'class' => 'callmez\wechat\sdk\Wechat',
            'appId' => 'wxd67d44974fa6111c',
            'appSecret' => 'f4793ce52883b15c9da1a11054929bc4',
            'token' => 're123de456m'
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
