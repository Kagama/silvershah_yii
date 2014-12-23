<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 14.08.14
 * Time: 18:55
 */
$this->params['breadcrumbs'] = [
    ['label' => 'Полезная информация', 'url' => ['/pages']],
    ['label' => $model->title, 'url' => null],
];
$this->title = $model->title." - Полезная информация - ".Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $model->seo_keywords]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $model->seo_description]);
?>
<div class="row no-padding-no-margin products-list" style="background-color: #fff">
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
                    <h1 class="title"><?= $model->title ?></h1>
                    <div class="text">
                        <?=$model->text?>
                    </div>
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