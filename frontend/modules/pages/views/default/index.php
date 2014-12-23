<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 14.08.14
 * Time: 18:55
 */
$this->params['breadcrumbs'] = [
    ['label' => 'Полезная информация', 'url' => null],
];
$this->title = "Полезная информация - ".Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['seo_keywords']]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['seo_description']]);
?>
<div class="row no-padding-no-margin products-list" style="background-color: #f4f4f4">
    <div class="align-center">
        <div class="row no-padding-no-margin">
            <div class="col-lg-9 no-padding-no-margin">
                <div class="show-new-page">
                    <div style="font-size: 12px;">
                        <?=
                        \yii\widgets\Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'encodeLabels' => false
                        ]) ?>
                    </div>
                    <h1 class="title">Полезная информация</h1>
                    <?php
                    foreach ($models as $model) {
                    ?>
                        <div class="" style="font-size: 12px;">
                            <?= \yii\helpers\Html::a($model->title, ['/'.$model->alt_title]); ?>
                            <p>
                                <?=$model->small_text?>
                            </p>
                        </div>
                    <?php
                    }

                    ?>
                </div>
            </div>
            <div class="col-lg-3 no-padding-no-margin">
                <?=
                \frontend\modules\catalog\widgets\PromoProductWidget::widget([
                    'view_type' => \frontend\modules\catalog\widgets\PromoProductWidget::VIEW_BLOCK,
                    'limit' => 4
                ]);
                ?>
            </div>
        </div>

    </div>
</div>