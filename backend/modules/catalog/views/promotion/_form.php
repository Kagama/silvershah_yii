<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductPromotion $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class="product-promotion-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="content container">
        <div class="row">
            <div class="col-lg-8">
                <section class="widget">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 254]) ?>

                    <label>Выберите товар по Акртиклу для связки с текущим продуктом.</label><br/>
                    <?php
                    $userArray = \common\modules\catalog\models\Product::find()->orderBy('code_number ASC')->all();
                    $sourceArr = [];
                    foreach ($userArray as $userAccount) {
                        $sourceArr[] = [
                            "value" => (string) $userAccount->h1_name,
                            'label' => (string) $userAccount->code_number,
                            'photo' => ((empty($userAccount->photos[0]) ? "" : $userAccount->photos[0]->doCache('100x100'))),
                            'id' => $userAccount->id];
                    }
                    ?>
                    <?=
                    \yii\jui\AutoComplete::widget([
                        'name' => 'product_code_number',
                        'id' => 'product_code_number2',
                        'clientOptions' => [
                            'source' => $sourceArr,
                            'autoFill' => true,
                            'minLength' => '2',
                            'select' => new \yii\web\JsExpression("function(event, ui){
                    addProductToRelationBlock('promo_product', ui.item, 'ProductPromotionRelation');
                }"),
                        ],
                    ]);
                    ?>
                    <section class="widget" style="margin-top: 10px; ">
                        <!--            <div class="body" >-->
                        <div class="row relatedblock-css promo_product" style="padding: 0 10px 0 10px;">
                            <?php


                            if (!empty($model->promoProdRel)) {
                                foreach ($model->promoProdRel as $index => $prod) {
                                    ?>
                                    <div class='col-lg-3'>
                                        <input type='hidden' name='ProductPromotionRelation[<?= $index ?>][product_id]'
                                               value='<?= $prod->product_id; ?>'/>
                                        <input class='promo_position' type='text'
                                               name='ProductPromotionRelation[<?= $index ?>][position]'
                                               value='<?= $prod->position; ?>' style='width:40px;'/>
                                        <a href='#' class='delete-rel-prod' onclick='deleteRelProd(this); return false;'><span
                                                class='glyphicon glyphicon-trash'></span></a>

                                        <p>
                                            <strong><?= $prod->product->code_number ?></strong> : <?= $prod->product->name ?>
                                        </p>
                                        <img
                                            src='/<?= (empty($prod->product->photos[0]) ? "" : $prod->product->photos[0]->doCache('100x100')) ?>'
                                            alt='<?= $prod->product->name ?>'/>

                                    </div>
                                <?php
                                }
                            }
                            ?>

                        </div>
                        <!--            </div>-->
                    </section>

                    <div class="form-actions">
                        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </section>
            </div>
            <div class="col-lg-4">
                <section class="widget">
                    <h4 style="font-size: 24px;"><i class="fa fa-cogs"></i> Настройки</h4>
                    <?=
                    $form->field($model, 'discount', [
                        'template' =>
                            '<div class="control-group">
                            <label class="control-label" for="combined-input">{label}</label>
                            <div class="controls form-group">
                                <div class="input-group col-sm-12">
                                    <span class="input-group-addon">%</span>
                                    {input}
                                </div>
                                <div class="help-block">{error}</div>
                                <span style="font-size: 12px; color:rgb(255, 255, 255); display: block; font-style: italic;"><span class="fa fa-warning"></span> Скидка будет добавлена каждому товару в этой группе</span>
                            </div>
                        </div>'
                    ])->textInput(); ?>

                    <?= $form->field($model, 'position')->textInput() ?>

                    <?= $form->field($model, 'active')->radioList(['Скрыть', 'Отобразить']); ?>
                    <?= $form->field($model, 'main_promo_block')->dropDownList(['Нет', 'Да']); ?>
                    <?= $form->field($model, 'prod_of_the_day')->dropDownList(['Нет', 'Да']); ?>

                </section>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    function addProductToRelationBlock($class, $item, $input_name) {

        var length = $("." + $class + ' div').length;
        $("." + $class).append("<div class='col-lg-3'>" +
            "<input type='hidden' name='" + $input_name + "[" + length + "][product_id]' value='" + $item.id + "' />" +
            "<input class='promo_position' type='text' name='" + $input_name + "[" + length + "][position]' value='999' style='width:40px;' />" +
            "<a href='#' class='delete-rel-prod' onclick='deleteRelProd(this); return false;'><span class='glyphicon glyphicon-trash'></span></a>" +
            "<p>" +
            "<strong>" + $item.value + "</strong> : " + $item.label + "" +
            "</p>" +
            "<img src='/" + $item.photo + "' alt='" + $item.label + "' />" +
            "</div>");
//        $index_of_lement = $index_of_lement + 1;
    }
    function deleteRelProd(_this) {
        $(_this).parent('div').remove();
        return false;
    }
</script>
