<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.09.14
 * Time: 15:58
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;


?>

<h3>Добавить отзыв</h3>
<?php $form = ActiveForm::begin([
    'action' => \yii\helpers\Url::toRoute(['/catalog/comment/add']),
    'options' => [
        'class' => 'comment-form',

    ]
]) ?>

<div class="row">
    <div class="col-lg-1 text-right">
        <label style="margin-top: 25px;">Рейтинг:</label>
    </div>
    <div class="col-lg-11">
        <?=
        $form->field($model, 'rate', [
            'template' => '{input}'
        ])->widget(\kartik\widgets\StarRating::className(), [
                'pluginOptions' => [
                    'glyphicon' => false,
                    'step' => 1,
                    'disabled' => false,
                    'showCaption' => false,
                    'showClear' => false,
                    'symbol' => mb_convert_encoding("&#9632;", 'UTF-8', 'HTML-ENTITIES')
                ],
            ])->label('') ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <?= $form->field($model, 'username') ?>
    </div>
    <div class="col-lg-6">
        <?= $form->field($model, 'email') ?>
    </div>
</div>
<?php
if (empty($product)) {
?>
    <?= Html::activeHiddenInput($model, 'product_id') ?>
<?php
} else {
?>
    <?= Html::activeHiddenInput($model, 'product_id', ['value' => $product->id]) ?>
<?php
}
?>

<?= Html::activeHiddenInput($model, 'date', ['value' => time()]) ?>
<?= $form->field($model, 'text')->textarea() ?>
<div class="text-right">
    <?= Html::button('Отмена', ['class' => 'cancel-form']) ?>
    <?= Html::button('Добавить', ['class' => 'submit-form']) ?>
</div>

<?php ActiveForm::end(); ?>
