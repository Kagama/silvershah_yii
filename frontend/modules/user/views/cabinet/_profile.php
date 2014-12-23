<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.09.14
 * Time: 19:28
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="user-form" style="margin-right: 20px;">
    <?=\frontend\widgets\Alert::widget()?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'phone', [
        'template' => '
        <div>{label}</div>
        {input}
        <div>{error}</div>
                    '
    ])->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '+7(999)-999-9999',
            'model' => $model,
            'attribute' => 'phone',
            'options' => [
                'placeholder' =>'+7(___)-___-____',
                'class' => 'input-type-text-medium'
            ]
        ]) ?>

    <?= $form->field($model, 'approve_newsletter')->checkbox(); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
