<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/libs.css',
        'css/main.css',
    ];
    public $js = [
//        'js/libs.js',
        'js/libs.min.js',
        'js/cookie/jquery.cookie.js',
        'js/cart.js',
        'js/scripts.js',
        //'js/main.js',


    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapPluginAsset',
    ];

//    public function init() {
//        $this->jsOptions['position'] = View::POS_BEGIN;
//        parent::init();
//    }

}
