<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductCategory $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>
<div class="content container">
    <div class="row">
        <div class="col-md-8">
            <section class="widget">
                <div class="body">
                    <?
                    if (!empty($model->src)) {
                        echo Html::tag('div',
                            Html::tag('div',
                                Html::img($model->doCache('200x200')) . Html::a(Html::tag('i', '', ['class' => 'fa fa-times-circle-o']) . " " . 'Удалить', ['/catalog/category/remove-img', 'id' => $model->id],
                                    [
                                        'class' => 'btn btn-danger',
//                            'data' => [
//                                'confirm' => 'Вы действительно хотите удалить фото?',
//                                'method' => 'get',
//                            ]
                                    ]), ['class' => 'photo-item']
                            ), ['class' => 'show-img']
                        );
                    }
                    ?>
                    <?= $form->field($model, 'img')->fileInput() ?>

                    <?= $form->field($model, 'h1')->textInput(['maxlength' => 254]) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => 254]) ?>

                    <?= $form->field($model, 'alt_name')->textInput(['maxlength' => 254]) ?>

                    <?=
                    $form->field($model, 'text_before', [
                        'template' => '
                            {label}
                            <div class="textarea-content">{input}</div>
                            {error}
                        '
                    ])->widget(sim2github\imperavi\widgets\Redactor::className(), [
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
                    $form->field($model, 'text_after', [
                        'template' => '
                                {label}
                                <div class="textarea-content">{input}</div>
                                {error}
                        '
                    ])->widget(sim2github\imperavi\widgets\Redactor::className(), [
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
                        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => 254]) ?>

                        <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => 512]) ?>

                        <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>
                    </fieldset>

                    <div class="form-actions">
                        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="widget">
                <div class="body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?= $form->field($model, 'position')->textInput() ?>
                        </div>
                        <div class="col-lg-12">
                            <?php
                            echo \common\helpers\html\mySelect::widget([
                                'model' => $model,
                                'attribute' => 'parent_id',
                                'data' => \common\modules\catalog\models\ProductCategory::find()->orderBy('position ASC')->all()
                            ]);
                            ?>
                            <?php
                            $form->field($model, 'parent_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\common\modules\catalog\models\ProductCategory::find()->all(), 'id', 'name'), ['prompt' => '---'])
                            ?>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<!--<section class="widget">-->
<!--    <div class="product-category-form ">-->
<!---->
<!---->
<!--        -->
<!--        -->
<!---->
<!---->
<!---->
<!--    </div>-->
<!--</section>-->
