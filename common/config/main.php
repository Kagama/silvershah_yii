<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'language' => 'ru-RU',
    'modules' => [
        'gii' => 'yii\gii\Module',
        'redactor' =>  'sim2github\imperavi\Module',
//
//        'pages' => [
//            'class' => 'backend\modules\pages\PagesModule',
//        ],
//        'user' => [
//            'class' => 'backend\modules\user\UserModule',
//        ],
//        'cart' => [
//            'class' => 'backend\modules\cart\CartModule',
//        ],
//        'order' => [
//            'class' => 'backend\modules\order\OrderModule',
//        ],
//        'catalog' => [
//            'class' => 'backend\modules\catalog\CatalogModule',
//        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ],


    ],
];
