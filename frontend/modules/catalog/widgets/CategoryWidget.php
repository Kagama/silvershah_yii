<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 30.06.14
 * Time: 14:51
 */
namespace frontend\modules\catalog\widgets;

use common\modules\catalog\models\ProductCategory;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;

class CategoryWidget extends Widget
{


    public function init()
    {
        $categories = ProductCategory::find()->orderBy('position, level ASC ')->all();
//        \Yii::$app->getView()->registerJs("
//            $('.catalog-category li.parent').hover(function () {
//                $(this).children('a').addClass('active');
//                if ($(this).children('.sub-menu').length > 0) {
//                    $(this).children('.sub-menu').show();
//                }
//            }, function () {
//                $(this).children('a').removeClass('active');
//                if ($(this).children('.sub-menu').length > 0) {
//                    $(this).children('.sub-menu').hide();
//                }
//            });
//        ", View::POS_END, 'category-widget');

        $html = '';

        $html .= $this->createULLI($categories, NULL) . "\n";
        echo $html;
    }

    private function createULLI($arr, $parent_id = NULL)
    {
        $str = "";
        foreach ($arr as $obj) {

            if ($obj->parent_id == $parent_id) {
                if ($obj->parent_id == null) {

                    $str .= Html::beginTag('div', ['class' => 'item']);
                    $str .= Html::tag('div', '', ['class' => 'icon ' . $this->getCssClassName($obj)]);

                    if (($ss = $this->createULLI($arr, $obj->id)) != "") {
                        $str .= Html::tag('span', $obj->h1);
                        $ss = Html::tag("li", Html::a($obj->h1, ['/' . $obj->prepareUrl()], ['style' => 'text-transform: uppercase;'])." &nbsp; &mdash; ", ['style' => 'color:#fff;']).$ss;
                        $str .= Html::tag('ul', $ss) . "\n";

                    } else {
                        $str .= Html::tag('span', Html::a($obj->name, ['/'.$obj->prepareUrl()]));
                    }


                } else {

                    $str .= Html::beginTag('li') . "\n";
                    $str .= Html::a($obj->name, ['/' . $obj->prepareUrl()]) . "\n";
                    $str .= Html::endTag('li') . "\n";

                }

                if ($obj->parent_id == null) {
                    $str .= Html::endTag('div');
                }
            }
        }

        return $str;
    }

    private function node($obj)
    {
        $space = "";
        for ($i = 0; $i < $obj->level; $i++) {
            $space .= "--";
        }
        $str = Html::tag('option', $space . $obj->name, ['value' => $obj->id, 'selected' => ($obj->id == $this->model->parent_id ? true : false)]) . "\n";
        return $str;
    }

    private function getCssClassName($obj)
    {
        $class = '';
        if ($obj->name == "Подарки из серебра, сувениры") {
            $class = 'gift';
        }
        if ($obj->name == "Кубачинское серебро") {
            $class = 'kub';
        }
        if ($obj->name == "Серебряная посуда") {
            $class = 'pos';
        }
        if ($obj->name == "Сервизы и столовые наборы") {
            $class = 'serv';
        }
        if ($obj->name == "Оружие из серебра") {
            $class = 'or';
        }
        if ($obj->name == "Эксклюзивная серебряная работа") {
            $class = 'ex';
        }
        if ($obj->name == "Антиквариат") {
            $class = 'ant';
        }

        return $class;
    }
}