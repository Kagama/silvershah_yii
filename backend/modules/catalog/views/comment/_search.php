<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\search\ProductCommentSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="product-comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'owner_id') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'like_count') ?>

    <?php // echo $form->field($model, 'unlike_count') ?>

    <?php // echo $form->field($model, 'product_id') ?>

    <?php // echo $form->field($model, 'approve') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'rate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
