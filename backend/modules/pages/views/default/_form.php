<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\pages\models\Pages $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<section class="widget">
    <div class="pages-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>

        <!--    --><? //= $form->field($model, 'alt_title')->textInput(['maxlength' => 512]) ?>

        <?=
        $form->field($model, 'small_text')->widget(sim2github\imperavi\widgets\Redactor::className(), [
            'options' => [
                'debug' => 'true',
            ],
            'clientOptions' => [ // [More about settings](http://imperavi.com/redactor/docs/settings/)
                'convertImageLinks' => 'true', //By default
                'convertVideoLinks' => 'true', //By default
                //'wym' => 'true',
                //'air' => 'true',
                'linkEmail' => 'true', //By default
                'lang' => 'ru',
                'imageGetJson' => \Yii::getAlias('@web') . '/redactor/upload/imagejson', //By default
                'plugins' => [ // [More about plugins](http://imperavi.com/redactor/plugins/)
                    'ace',
                    'clips',
                    'fullscreen']
            ],
        ]) ?>

        <?=
        $form->field($model, 'text')->widget(sim2github\imperavi\widgets\Redactor::className(), [
            'options' => [
                'debug' => 'true',
            ],
            'clientOptions' => [ // [More about settings](http://imperavi.com/redactor/docs/settings/)
                'convertImageLinks' => 'true', //By default
                'convertVideoLinks' => 'true', //By default
                //'wym' => 'true',
                //'air' => 'true',
                'linkEmail' => 'true', //By default
                'lang' => 'ru',
                'imageGetJson' => \Yii::getAlias('@web') . '/redactor/upload/imagejson', //By default
                'plugins' => [ // [More about plugins](http://imperavi.com/redactor/plugins/)
                    'ace',
                    'clips',
                    'fullscreen']
            ],
        ]) ?>
        <fieldset>
            <legend>SEO Атрибуты</legend>
            <?= $form->field($model, 'seo_title')->textInput(['maxlength' => 512]) ?>

            <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => 512]) ?>

            <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>
        </fieldset>


        <div class="form-actions">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</section>
