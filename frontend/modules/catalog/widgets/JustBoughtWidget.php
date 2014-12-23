<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.09.14
 * Time: 18:50
 */

namespace frontend\modules\catalog\widgets;

use common\modules\catalog\models\Product;
use common\modules\order\models\Order;
use yii\base\Widget;

class JustBoughtWidget extends Widget
{
    public function run()
    {
        $order = Order::find()->orderBy('date DESC')->one();
        $products = [];

        foreach ($order->cart->cartItems as $item) {
            $products[] = Product::findOne($item->product_id);
        }

        return $this->render('_just_bought', ['products' => $products]);
    }
}