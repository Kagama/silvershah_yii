<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.08.14
 * Time: 15:10
 */

namespace frontend\modules\catalog\widgets;

use common\modules\catalog\models\ProductSlider;
use yii\base\Widget;

class SliderWidget extends Widget
{

    public function run()
    {
        $models = ProductSlider::find()->where('active = 1')->all();
        return $this->render('_slider', ['models' => $models]);
    }

}