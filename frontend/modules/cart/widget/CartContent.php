<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.08.14
 * Time: 13:41
 */
namespace frontend\modules\cart\widget;

use common\modules\cart\models\Cart;
use yii\base\Widget;

class CartContent extends Widget
{
    public $type = 'full';
    public function run()
    {
        $cart = new Cart();
        $cart->getCart();

        return $this->render('_cart_content', [
            'cart' => $cart,
            'type' => $this->type
        ]);
    }
}