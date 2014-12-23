<?php

namespace frontend\modules\cart;

use common\componets\myModule;

class CartModule extends myModule
{
    public $controllerNamespace = 'frontend\modules\cart\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function rules () {
        $ruleArr['add-to-cart'] = 'cart/default/add';
        $ruleArr['cart/delete'] = 'cart/default/delete';
        $ruleArr['cart-remove'] = 'cart/default/remove';
        $ruleArr['get-cart-content'] = 'cart/default/get-content';


        return $ruleArr;
    }
}
