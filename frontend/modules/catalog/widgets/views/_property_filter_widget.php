<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.07.14
 * Time: 3:40
 */

$PropertyFilter = Yii::$app->request->get('PropertyFilter');

use yii\web\View;

Yii::$app->view->registerJs('
    $(".product-filter-widget .accept").on("click", function(){
//        var serialize = decodeURIComponent($(".product-filter-widget").serialize());
//        var url = window.document.location.href.split("?");
//        $(".product-filter-widget").attr("action",url[0]+"?"+serialize);
//        return false;
    });
    $(".property_group .title").on("click", function(){
        var _title = $(this);
        $(this).next(".property_values").slideToggle("slow");
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
        } else {
            $(this).addClass("active");
        }
    });
    $(".property_group .property_values input:checked").each(function(){
        var _property_values = $(this).parent("li").parent("ul").parent("div.property_values");
        $(_property_values).show();
        $(_property_values).prev(".title").addClass("active");
    });


', View::POS_END, 'product-filter-widget');

?>
<div class="product-filter" style="padding-bottom: 60px;">
    <span class="title" style="padding-bottom: 20px; display: block; font-size: 18px;">Расширенный поиск</span>

    <?php
    \yii\widgets\ActiveForm::begin([
        'method' => 'get',
        'action' => \yii\helpers\Url::to(['/catalog/' . $category->alt_name, 'sort' => Yii::$app->request->get('sort')]),
        'options' => [
            'class' => 'product-filter-widget',
            'data-pjax' => '1'
        ]
    ]);

    ?>
    <div class="property">
        <ul class="property_group">

            <li>
                <span class="title <?= (isset($PropertyFilter['price']) ? 'active' : "")?>">Цена <span class="grey-arrow">&nbsp;</span></span>
                <div class="property_values price-filter" <?= (isset($PropertyFilter['price']) ? 'style="display: block;"' : "")?>>
                    <?php
                    $input_min_price_value = (int) (isset($PropertyFilter['price']['min']) ?  $PropertyFilter['price']['min'] : $price_range['min_price']);
                    $input_max_price_value = (int) (isset($PropertyFilter['price']['max']) ?  $PropertyFilter['price']['max'] : $price_range['max_price']);
                    ?>
                    <?=\yii\jui\Slider::widget([
                        'clientOptions' => [
                            'min' => (int) $price_range['min_price'],
                            'max' => (int) $price_range['max_price'],
                            'range' => true,
                            'values' => [$input_min_price_value, $input_max_price_value],
                            'step' => 250,
                            'slide' => new \yii\web\JsExpression(" function (event, ui) {
                                    $('#PropertyFilter-price-min').val(ui.values[0]);
                                    $('#PropertyFilter-price-max').val(ui.values[1]);
                            }"),
                            'change' => new \yii\web\JsExpression("function(event, ui) {
                                    $('.product-filter-widget').submit();
                            }")
                        ]
                    ])?>
                    <br />
                    От&nbsp;<?= \yii\helpers\Html::textInput("PropertyFilter[price][min]", $input_min_price_value, ['id' => 'PropertyFilter-price-min']) ?>&nbsp;До&nbsp;<?= \yii\helpers\Html::textInput("PropertyFilter[price][max]", $input_max_price_value, ['id' => 'PropertyFilter-price-max']) ?>

                </div>
            </li>
        </ul>
        <ul class="property_group">
            <li>
                <span class="title <?= (isset($PropertyFilter['manufacturer']) ? 'active' : "")?>">Производитель <span class="grey-arrow">&nbsp;</span></span>
                <div class="property_values" <?= (isset($PropertyFilter['manufacturer']) ? 'style="display: block;"' : "")?>>
                    <ul>
                        <?php
                        foreach ($fabric_range as $fabric) {
                            $selected = false;
                            if ($PropertyFilter != null && isset($PropertyFilter['manufacturer'])) {
                                $selected = in_array($fabric['id'], $PropertyFilter['manufacturer']);
                            }
                            ?>
                            <li>
                                <?= \yii\helpers\Html::checkbox("PropertyFilter[manufacturer][" . $fabric['id'] . "]", $selected, ['value' => $fabric['id'], 'id' => 'PropertyFilter-manufacturer-' . $fabric['id']]) ?>
                                <?= \yii\helpers\Html::label($fabric['name'], "PropertyFilter-manufacturer-" . $fabric['id'] . "") ?>

                            </li>
                        <?php
                        }
                        ?>
                    </ul>
<!--                    <div class="buttons">-->
<!--                        --><?//= \yii\helpers\Html::submitButton('Применить', ['class' => 'accept']) ?>
<!--                        --><?//= \yii\helpers\Html::button('Сбросить', ['class' => 'reset']) ?>
<!--                    </div>-->
                </div>
            </li>
        </ul>
        <?php
        $count = count($properties);
        if (!empty($properties)) {
            foreach ($properties as $index=>$property) {
                if (!empty($property['property_values'])) {
                    ?>
                    <ul class="property_group <?=$count == ($index+1) ? 'last_property_group' : ''?>">
                        <li>
                            <span class="title "><?= $property['name'] ?> <span class="grey-arrow">&nbsp;</span></span>

                            <div class="property_values">
                                <ul>
                                    <?php
                                    foreach ($property['property_values'] as $property_value) {
                                        $selected = false;
                                        if ($PropertyFilter != null && isset($PropertyFilter[$property['property_name']])) {
                                            $selected = in_array($property_value['id'], $PropertyFilter[$property['property_name']]);
                                        }
                                        ?>
                                        <li>
                                            <?= \yii\helpers\Html::checkbox("PropertyFilter[" . $property['property_name'] . "][" . $property_value['id'] . "]", $selected, ['value' => $property_value['id'], 'id' => 'PropertyFilter-' . $property['property_name'] . '-' . $property_value['id']]) ?>
                                            <?= \yii\helpers\Html::label($property_value['value'], "PropertyFilter-" . $property['property_name'] . "-" . $property_value['id'] . "") ?>

                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
<!--                                <div class="buttons">-->
<!--                                    --><?//= \yii\helpers\Html::submitButton('Применить', ['class' => 'accept']) ?>
<!--                                    --><?//= \yii\helpers\Html::button('Сбросить', ['class' => 'reset']) ?>
<!--                                </div>-->
                            </div>
                        </li>

                    </ul>
                <?php
                }
            }
            ?>
<!--            <ul class="property_group" style="border:none; border-top: 1px solid #e6e6e6;">-->
<!--                <li>-->
<!--                    <div class="buttons" >-->
<!--                        --><?//= \yii\helpers\Html::submitButton('Применить', ['class' => 'accept']) ?>
<!--                        --><?//= \yii\helpers\Html::button('Сбросить', ['class' => 'reset']) ?>
<!--                    </div>-->
<!--                </li>-->
<!--            </ul>-->
        <?php
        }
        ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
