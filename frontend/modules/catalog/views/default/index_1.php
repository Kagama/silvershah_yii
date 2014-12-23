<?php
/**
 * @var yii\web\View $this
 */
$this->title = 'Главная';


$this->title = Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['seo_keywords']]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['seo_description']]);
?>
<!-- category-and-slider -->
<div style="background-color: #fff; padding-bottom: 60px; padding-top: 10px;" class="content-block-top-shadow">


    <div class="row no-padding-no-margin category-and-slider">
        <div class="align-center">
            <div class="col-lg-3 no-padding-no-margin">
                <?php
                echo \frontend\modules\catalog\widgets\CategoryWidget::widget();
                ?>
            </div>
            <div class="col-lg-9 no-padding-no-margin">
                <div class="row no-padding-no-margin">
                    <div class="col-lg-12 no-padding-no-margin" style="margin-left: 10px">
                        <?=\frontend\modules\catalog\widgets\SliderWidget::widget()?>
                    </div>
                    <?=\frontend\modules\catalog\widgets\JustBoughtWidget::widget()?>
                </div>
            </div>
        </div>
    </div>
    <!-- конец category-and-slider -->
    <!-- товар для и супер цена -->
    <div class="row no-padding-no-margin" style="height: 342px;">
        <div class="align-center" style="height: 342px; border-bottom:2px solid #f2f2f2;">
            <?=
            \frontend\modules\catalog\widgets\PromoProductWidget::widget([
                'prod_of_the_day' => 1,
                'limit' => 1
            ]);
            ?>


            <?=
            \frontend\modules\catalog\widgets\PromoProductWidget::widget([
                'main_promo_block' => 1,
                'limit' => 'no-limit'
            ]);
            ?>

        </div>
    </div>
    <!-- конец товар для и супер цена -->
    <!-- Продвигаемая продукция -->
    <?=
    \frontend\modules\catalog\widgets\PromoProductWidget::widget([
    ]);
    ?>
</div>