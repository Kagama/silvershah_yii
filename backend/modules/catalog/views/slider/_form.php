<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductSlider $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="product-slider-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 512]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'active')->dropDownList(['Нет', 'Да']) ?>
        </div>
    </div>
    <?= $form->field($model, 'href')->textInput() ?>
    <fieldset>
        <legend>Слайд</legend>
        <?php
        if ($model->img_name != "") {

        ?>
            <?=Html::img("/".$model->doCache('600x600', 'width'))?>
            <?=Html::a('Удалить фото', ['/catalog/slider/delete-photo', 'id' => $model->id])?>
        <?php
        } else {
        ?>
            <?= $form->field($model, 'img_name')->fileInput() ?>
        <?php
        }
        ?>

    </fieldset>






    <div class="form-actions">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
