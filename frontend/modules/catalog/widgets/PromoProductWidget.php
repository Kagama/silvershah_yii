<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.07.14
 * Time: 15:38
 */

namespace frontend\modules\catalog\widgets;

use common\modules\catalog\models\ProductPromotion;
use yii\base\Widget;

class PromoProductWidget extends Widget
{
    const VIEW_LIST = 0;
    const VIEW_BLOCK = 1;
    public $limit = 5;
    public $view_type = 0; //  = VIEW_LIST
    public $prod_of_the_day = 0;
    public $main_promo_block = 0;

    public function run()
    {

        if ($this->main_promo_block == 1 && $this->prod_of_the_day == 1) {
            return null;
        }

        $query = ProductPromotion::find();
        $query->orderBy('position ASC')->where('
            active = 1 and
            main_promo_block = ' . $this->main_promo_block . ' and
            prod_of_the_day = ' . $this->prod_of_the_day . '
        ');
        if ($this->limit != 'no-limit') {
            $query->limit($this->limit);
        }
        $promoBlocks = $query->all();
        if (!empty($promoBlocks)) {
            if ($this->main_promo_block == 1) {
                return $this->render('promo-product-widget/_promo_product_widget_main_block', [
                    'promoBlocks' => $promoBlocks
                ]);
            } else if ($this->prod_of_the_day == 1) {
                return $this->render('promo-product-widget/_promo_product_widget_prod_of_the_day', [
                    'promoBlocks' => $promoBlocks
                ]);
            } else {
                return $this->render('promo-product-widget/_promo_product_widget' . ($this->view_type == self::VIEW_LIST ? "_list" : "_block"), [
                    'promoBlocks' => $promoBlocks
                ]);
            }
        }
    }
}