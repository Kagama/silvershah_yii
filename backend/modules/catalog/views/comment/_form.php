<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductComment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="product-comment-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false
    ]); ?>
    <div class="row">
        <div class="col-lg-5">
            <?= $form->field($model, 'email')->textInput(['maxlength' => 254]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'username')->textInput(['maxlength' => 254]) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'date')->textInput(['class' => 'date-picker2 form-control', 'style' => 'width:90px;']); ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('.date-picker2').datepicker({
                        format: "dd-mm-yyyy"

                    });
                });
            </script>
        </div>
    </div>


    <?= $form->field($model, 'approve')->dropDownList(['Нет', 'Да']); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="row">
        <div class="col-lg-3">
            <?php
            if (!empty($model->product->photos[0]))
                echo Html::img("/" . $model->product->photos[0]->doCache('250x250'));
            ?>
        </div>
        <div class="col-lg-9">
            <?php
            echo Html::a($model->product->code_number . " | " . $model->product->name, '/product/' . $model->product->code_number . ".html", ['target' => '_blank'])
            ?>
        </div>
    </div>
    <?= $form->field($model, 'rate')->hiddenInput()->label('') ?>
    <?= $form->field($model, 'product_id')->hiddenInput()->label('') ?>



    <!--    --><? //= $form->field($model, 'owner_id')->textInput() ?>



    <!--    --><? //= $form->field($model, 'like_count')->textInput() ?>

    <!--    --><? //= $form->field($model, 'unlike_count')->textInput() ?>





    <!--    --><? //= $form->field($model, 'level')->textInput() ?>

    <div class="form-actions">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
