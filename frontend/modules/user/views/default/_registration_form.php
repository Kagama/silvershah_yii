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
    'action' => \yii\helpers\Url::to(['/registration']),
    'method' => 'post'
]); ?>
    <h1 style="color: #fff;">Регистрация</h1>
    <div class="row">
        <div>
            <?=$form->errorSummary($model);?>
        </div>
        <div class="col-lg-12">
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

    </div>

    <div class="form-group">
        <?= Html::button('Регистрация', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php $this->endBody() ?>
<?php $this->endPage() ?>