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
//    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'admin/default',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'backend\modules\admin\AdminModule',
        ],
        'pages' => [
            'class' => 'backend\modules\pages\PagesModule',
        ],
        'post' => [
            'class' => 'backend\modules\post\PostModule',
        ],
        'catalog' => [
            'class' => 'backend\modules\catalog\CatalogModule',
        ],
        'user' => [
            'class' => 'backend\modules\user\UserModule',
        ],
        'order' => [
            'class' => 'backend\modules\order\OrderModule',
        ],
        'redactor' =>  'sim2github\imperavi\Module',
        'export' => [
            'class' => 'backend\modules\export\ExportModule'
        ],
        'menu' => [
            'class' => 'backend\modules\menu\MenuModule',
        ],
        'appmodule' => [
            'class' => 'backend\modules\appmodule\AppModule',
        ],
    ],
    'components' => [
        'session' => [
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'backend_session'
        ],
        'request' => [
            'enableCsrfValidation'=>false,
            'baseUrl' => '/cp', // данный адрес соответсвует с тем адресом который мы задали в .htaccess из общего рута нашего приложения.
            'cookieValidationKey' => 'Bvd12Sad1',
        ],

        'user' => [
            'identityClass' => 'backend\modules\admin\models\AdminUsers',
            'enableAutoLogin' => true,
            'loginUrl' => 'admin/default/login.html'
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/lightblue',
                    '@app/modules' => '@app/themes/lightblue/modules', // <-- !!!
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
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
            'errorAction' => 'admin/default/error',
        ],
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [''] // тут путь до Вашего экземпляра jquery
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules'=>[

////
//                '<module:\w+>/<action:\w+>'=>'<module>/default/<action>',
//                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
//
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//////
//                'gii'=>'gii/default/index',
//                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
            ]
        ],
    ],
    'params' => $params,
];
