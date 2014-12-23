<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.08.14
 * Time: 17:57
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;


//Yii::$app->view->registerJs('
//
//    alert("sdfsdf");
//
//', View::POS_READY,'login-form-js');

?>

<?php $this->beginPage() ?>
<?php $this->head() ?>
<?php $this->beginBody() ?>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'class' => 'login-form-ajax',
    'action' => \yii\helpers\Url::to(['/login']),
    'method' => 'post'
]); ?>
<h1 style="color: #fff;">Вход</h1>
    <div class="hint">
        Если вы забыли свой пароль, его можно <?= Html::a('сбросить.', ['/request-password-reset'], ['class' => 'request-password-reset']) ?>
    </div>
<div class="row">
    <div>
        <?=$form->errorSummary($model);?>
    </div>
    <div class="col-lg-6">
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
    </div>
    <div class="col-lg-6">
        <?= $form->field($model, 'password', [
            'template' => '
                {label}
                {input}
                {error}'
        ])->passwordInput() ?>
    </div>
</div>
<?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php $this->endBody() ?>
<?php $this->endPage() ?>