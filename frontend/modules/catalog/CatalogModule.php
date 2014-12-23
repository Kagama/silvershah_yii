<?php

namespace frontend\modules\catalog;

use common\componets\myModule;
use common\modules\catalog\models\ProductCategory;

class CatalogModule extends myModule
{
    public $controllerNamespace = 'frontend\modules\catalog\controllers';

    public function init()
    {

        parent::init();

        // custom initialization code goes here
    }

    public function rules () {

        $categories = ProductCategory::find()->all();

        $url = "";
        $ruleArr = [];
        foreach ($categories as $cat) {
            $url .= (empty($url) ? "" : "|" ).str_replace("/", "\/", $cat->prepareUrl());
        }

        $ruleArr['<cat_url:('.$url.')>'] = 'catalog/category/index';
        $ruleArr['/<id:\d+>/<code_h1:\w+>'] = 'catalog/default/show';
        $ruleArr['add-to-favorite'] = 'catalog/default/add-to-favorite';
        $ruleArr['favorite'] = 'catalog/default/favorite';

        return $ruleArr;
    }
}
