<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.09.14
 * Time: 19:46
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="user-form" style="margin-right: 20px;">
    <?=\frontend\widgets\Alert::widget()?>
    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'old_password')->textInput(['value' => ''])?>
    <?=$form->field($model, 'password')->passwordInput(['value' => ''])?>
    <?=$form->field($model, 'password_repeat')->passwordInput(['value' => ''])?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>