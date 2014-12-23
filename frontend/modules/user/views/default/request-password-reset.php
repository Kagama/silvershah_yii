<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var common\models\User $model
 */
$this->title = 'Востановить пароль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row no-padding-no-margin products-list" style="background-color: #f4f4f4; height: 300px;">
    <div class="align-center">
        <div class="row no-padding-no-margin">
            <div class="col-lg-12">
                <?= \frontend\widgets\Alert::widget() ?>
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <div class="site-request-password-reset">
                    <div style="font-size: 12px;">
                        <?=
                        \yii\widgets\Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'encodeLabels' => false
                        ]) ?>
                    </div>
                    <h1 class="title"><?= Html::encode($this->title) ?></h1>

                    <p style="font-size: 14px;">Пожалуйста заполнителе поле номер телефона. Новый пароль будет выслан вам на
                        номер мобильного
                        телефона.</p>

                    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '+7(999)-999-9999',
                        'model' => $model,
                        'attribute' => 'phone',
                        'options' => [
                            'placeholder' => '+7(___)-___-____',
                            'class' => 'input-type-text-medium',
                            'style' => 'width:400px; font-size:14px;'
                        ]
                    ]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Выслать новый пароль', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
