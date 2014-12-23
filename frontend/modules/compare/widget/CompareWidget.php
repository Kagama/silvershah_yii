<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.09.14
 * Time: 14:54
 */

namespace frontend\modules\compare\widget;

use yii\base\Widget;

class CompareWidget extends Widget
{
    public $product;

    public function run()
    {
        return $this->render('_compare', [
            'product' => $this->product
        ]);
    }
}