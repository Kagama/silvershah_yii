<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.07.14
 * Time: 0:46
 */

namespace frontend\modules\cart\widget;

use common\modules\cart\models\Cart;
use yii\base\Widget;

class UserCartWidget extends Widget
{
    public function run()
    {
        $cart = new Cart();
        $cart->getCart();
        return $this->render('_user_cart',[
            'cart' => $cart
        ]);
    }
}