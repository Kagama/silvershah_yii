<?php

namespace frontend\modules\order;

use common\componets\myModule;

class OrderModule extends myModule
{
    public $controllerNamespace = 'frontend\modules\order\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function rules() {
        $ruleArr['create-order'] = 'order/default/create';
        $ruleArr['confirm-order'] = 'order/default/confirm';

        return $ruleArr;
    }
}
