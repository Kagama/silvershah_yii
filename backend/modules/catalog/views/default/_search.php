<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\search\ProductSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code_number') ?>

    <?= $form->field($model, 'model') ?>

    <?= $form->field($model, 'manufacture_id') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'alt_name') ?>

    <?php // echo $form->field($model, 'h1_name') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'old_price') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'product_type_id') ?>

    <?php // echo $form->field($model, 'visible') ?>

    <?php // echo $form->field($model, 'seo_title') ?>

    <?php // echo $form->field($model, 'seo_keywords') ?>

    <?php // echo $form->field($model, 'seo_description') ?>

    <?php // echo $form->field($model, 'rate') ?>

    <?php // echo $form->field($model, 'rate_count') ?>

    <?php // echo $form->field($model, 'pre_order') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
