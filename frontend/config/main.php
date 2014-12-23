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
    'language' => 'ru',
//    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'catalog/default/index',
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => 'yii\gii\Module',

        'pages' => [
            'class' => 'frontend\modules\pages\PagesModule',
        ],
        'search' => [
            'class' => 'frontend\modules\search\SearchModule',
        ],
        'user' => [
            'class' => 'frontend\modules\user\UserModule',
        ],
        'cart' => [
            'class' => 'frontend\modules\cart\CartModule',
        ],
        'post' => [
            'class' => 'frontend\modules\post\PostModule',
        ],
        'order' => [
            'class' => 'frontend\modules\order\OrderModule',
        ],
        'catalog' => [
            'class' => 'frontend\modules\catalog\CatalogModule',
        ],
        'compare' => [
            'class' => 'frontend\modules\compare\CompareModule',
        ],
    ],
    'as myDModuleUrlRulesBehavior' => [
        'class' => 'common\behaviors\DModuleUrlRulesBehavior',
    ],
    'components' => [
        /*'sms' => [
            'class' => 'Zelenin\yii\extensions\Sms',
            'api_id' => 'c88d9c8c-feef-b1d4-d1ee-cfa1474b5415',
            'login' => '9637944343',
            'password' => '123asdruaz159'
        ],*/
        'session' => [
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'frontend_session',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules', // <-- !!!
                ],
            ],
        ],
//        'security' => [
//            'cryptBlockSize' => 16,
//            'cryptKeySize' => 24,
//            'derivationIterations' => 1000,
//            'deriveKeyStrategy' => 'hmac', // for PHP version < 5.5.0
//            //'deriveKeyStrategy' => 'pbkdf2', // for PHP version >= 5.5.0
//            'useDeriveKeyUniqueSalt' => false,
//        ],
        'request' => [
            'baseUrl' => '', // данный адрес соответсвует с тем адресом который мы задали в .htaccess из общего рута нашего приложения.
            'cookieValidationKey' => 'Bvd12Sad1',
        ],
        'user' => [
            'identityClass' => 'common\modules\user\models\User',
            'enableAutoLogin' => true,
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
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets'
        ],
        'urlManager' => [
//            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
//            'rules'=>[

//                '<module:(news|article)>/all' => '<module>/default/all',
//                '<module:(news|article)>/<id_alt_title:\w+>' => '<module>/default/show',

//                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
//                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//            ]
        ],
//        'urlManager' => [
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'suffix' => '.html',
//            'rules'=>[
//                // Каталог
//                'catalog/<category_name:\w+>' => 'catalog/category/index',
//                'product/<code_number:\w+>' => 'catalog/default/show',
//                'promotion-products/<id_alt_name:\w+>' => 'catalog/promotion/index',
//                'add-to-wish-list' => 'catalog/default/add-to-wish-list',
//
//                // Сравнение товаров
//                'add-to-compare' => 'compare/default/add',
//                'show-compare-products' => 'compare/default/show',
//                'remove-from-comparison' => 'compare/default/remove',
//
//
//                // Новости
//                'news/all' => 'news/default/index',
//                'news/<id_alt_name:\w+>' => 'news/default/show',
//
//                // Корзина
//                'cart' => 'cart/default/index',
//                'add-to-cart' => 'cart/default/add',
//                'cart/delete/<id:\d+>' => 'cart/default/delete',
//                'cart/remove' => 'cart/default/remove',
//
//                // Заказ
//                'create-order' => 'order/default/create',
//                'fast-order' => 'order/default/fast',
//
//                // Пользователь
//                'login' => 'user/default/login',
//                'logout' => 'user/default/logout',
//                'registration' => 'user/default/registration',
//                'cabinet' => 'user/cabinet/index',
//                'request-password-reset' => 'user/default/request-password-reset',
//
//                // Страницы
//                'pages' => 'pages/default/index',
//                '<page:(dostavka|oplata|kontakty)>' => 'pages/default/show',
//
//                // Поиск
//                'search' => 'search/default/index',

////
//                '<module:\w+>/<action:\w+>'=>'<module>/default/<action>',
//                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
//                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
////
//                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//////
//                'gii'=>'gii/default/index',
//                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
//            ]
//        ],
    ],
    'params' => $params,
];


