<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\search\ProductCategorySearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="product-category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'alt_name') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?= $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'src') ?>

    <?php // echo $form->field($model, 'text_before') ?>

    <?php // echo $form->field($model, 'text_after') ?>

    <?php // echo $form->field($model, 'seo_title') ?>

    <?php // echo $form->field($model, 'seo_keywords') ?>

    <?php // echo $form->field($model, 'seo_description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
