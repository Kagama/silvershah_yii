<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductProperty $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<section class="widget">
    <div class="product-property-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'backend_name')->textInput(['maxlength' => 254]) ?>

        <?= $form->field($model, 'frontend_name')->textInput(['maxlength' => 254]) ?>

        <div class="form-actions">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</section>
