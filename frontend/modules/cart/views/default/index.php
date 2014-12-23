<?php
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'] = [
    ['label' => 'Корзина', 'url' => null]
];

$this->title = "Корзина - ".Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['seo_keywords']]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['seo_description']]);

?>
<div class="row no-padding-no-margin content-block-top-shadow" style="background-color: #fff;">
    <div class="align-center">
        <div class="row cart-content">
            <div class="col-lg-9 no-padding-no-margin">
                <div style="margin-right: 10px;">
                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <h1>Корзина</h1>
                    <?=\frontend\modules\cart\widget\CartContent::widget();?>
                </div>

            </div>
            <div class="col-lg-3 no-padding-no-margin">
                <?=
                \frontend\modules\catalog\widgets\PromoProductWidget::widget([
                    'prod_of_the_day' => 1,
                    'limit' => 1
                ]);
                ?>
                <div class="clearfix">&nbsp;</div>
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
