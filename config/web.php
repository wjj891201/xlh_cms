<?php

$params = require(__DIR__ . '/params.php');

Yii::$classMap['Simple_html_dom'] = '@app/libs/Simple_html_dom.php';
Yii::$classMap['Mypdf']           = '@app/libs/pdf/Mypdf.php';

$config = [
    'timeZone' => 'Asia/Chongqing',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => "index",
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xlh_cms'
        ],
        'urlManager' => require(__DIR__ . '/url.php'),
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        # 审批用户的认证类
        'approvr_user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\ApproveUser',
            'enableAutoLogin' => true,
        ],
        # 系统默认提供的认证类
        'user' => [
            'identityClass' => 'app\models\ApproveUser',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                    '@app/views' => '@app/themes/christmas/views',
//                ],
//                'baseUrl' => '@app/themes/christmas/views',
//        ],
//        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => '15195861092',
                'password' => '891201wjp',
                'port' => '465',
                'encryption' => 'ssl',
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
        'db' => require(__DIR__ . '/db.php'),
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
//            'itemTable' => 'auth_item',
//            'assignmentTable' => 'auth_assignment',
//            'itemChildTable' => 'auth_item_child',
        ],
        'jwt' => [
            'class' => 'sizeg\jwt\Jwt',
            'key' => 'secret',
        ],
        //去除 JQuery 脚本
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [], // 去除 jquery.js
                    'sourcePath' => null, // 防止在/web/asset 下生产文件
                ],
            ],
        ],
    ],
    'params' => $params,
    //模块
    'modules' => [
        'admin' => ['class' => 'app\modules\admin\admin'],
        'approve' => ['class' => 'app\modules\approve\approve'],
    ],
];

if (YII_ENV_DEV)
{
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
//        'allowedIPs' => '[192.168.1.101]'
    ];
}

return $config;
