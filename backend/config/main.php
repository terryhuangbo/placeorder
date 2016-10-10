<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'admin/index/index',//默认路由，控制器+方法
    'modules' => [
        'admin' => 'app\modules\admin',//默认模块
        'team' => 'app\modules\team\TeamModule',//后台用户管理
        'treemanager' => ['class' => '\kartik\tree\Module'],//后台分类管理插件模块引用，
        // 公用
        'common' => [
            'class' => 'backend\modules\common\Module',
        ],
        // 用户
        'user' => [
            'class' => 'backend\modules\user\Module',
        ],
        // 积分
        'points' => [
            'class' => 'backend\modules\points\Module',
        ],
        // 商品
        'goods' => [
            'class' => 'backend\modules\goods\Module',
        ],
        // 订单
        'order' => [
            'class' => 'backend\modules\order\Module',
        ],
        // 信用
        'trust' => [
            'class' => 'backend\modules\trust\Module',
        ],
        // 认证
        'auth' => [
            'class' => 'backend\modules\auth\Module',
        ],
        // 行业
        'industry' => [
            'class' => 'backend\modules\industry\Module',
        ],
        // 会员
        'vip' => [
            'class' => 'backend\modules\vip\Module',
        ],
    ],
    'components' => [
        'db' => require(__DIR__ . '/../../common/config/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //路由管理
            'rules' => [
                "<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>" => "<module>/<controller>/<action>",
                "<module:\w+>/<controller:\w+>/<action:\w+>/<id:\w+>" => "<module>/<controller>/<action>",
                "<controller:\w+>/<action:\w+>/<id:\d+>" => "<controller>/<action>",
                "<controller:\w+>/<action:\w+>" => "<controller>/<action>",
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\YiiUser',//模型自动登录
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/index/login'],//定义后台默认登录界面[权限不足跳到该页]
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules',
                ],
            ],
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
