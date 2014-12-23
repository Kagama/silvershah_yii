<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.07.14
 * Time: 20:44
 */
namespace frontend\modules\catalog\widgets;

use yii\base\Exception;
use yii\base\Widget;

class RenderPromotionProductWidget extends Widget
{
    const VIEW_HORIZIONTAL = 'horizontal';
    const VIEW_VERTICAL = 'vertical';

    public $view_type = null;
    public $models = null;
    public $title = "";
    public function run()
    {
        if ($this->view_type == null)
            throw new \BadFunctionCallException('Не заполнено обязатальено поле '.RenderPromotionProductWidget::className().'::view_type ');

        return $this->render('_'.$this->view_type."_promotion_products", ['models' => $this->models, 'title' => $this->title]);
    }
}