<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.07.14
 * Time: 20:09
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\web\View;


Yii::$app->view->registerJs("
    $('.fancybox-thumb').fancybox({
        prevEffect	: 'none',
        nextEffect	: 'none',
        helpers	: {
            title	: {
                type: 'outside'
            },
            thumbs	: {
                width	: 50,
                height	: 50
            }
        }
    });

    $('.add-comment-btn').on('click', function(){
    var _url = $(this).attr('href');
    $.ajax({
        type:'get',
        dataType:'json',
        url:_url,
        success : function(json) {
            if (json.error) {
                alert(json.message);
            } else {
                $('.comment-form-block').empty();
                $('.comment-form-block').html(json.content);
            }
        }
    });

    return false;
   });

", \yii\web\View::POS_END, 'product-show-photo');


$this->params['breadcrumbs'] = [
    ['label' => $model->category->name, 'url' => ['/catalog/' . $model->category->alt_name]],
    ['label' => $model->name, 'url' => null],
];


$this->title = $model->name." - ".$model->category->name." - ".Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $model->seo_keywords]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $model->seo_description]);

?>
<div class="row no-padding-no-margin products-list" style="background-color: #fff;">
    <div class="align-center">
        <div class="row product-show">
            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <h1><?= $model->name ?></h1>

            <div class="col-lg-6 no-padding-no-margin">
                <div class="main-photo">
                    <?php
                    $mainPhoto = $model->photos[0];
                    echo Html::img("/".$mainPhoto->doCache('408x348', 'auto'));
                    ?>
                </div>
                <div class="thumb">
                    <?php
                    foreach ($model->photos as $index => $photo) {
                        echo Html::a(Html::img("/".$photo->doCache('86x86', 'auto', '46x46')), "/".$photo->doCache('600x600', 'auto'), ['class'=> "fancybox-thumb ".($index == 0 ? "active" : ""), 'rel'=>"fancybox-thumb"]);
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-6 no-padding-no-margin">

                <span class="code-number">Артикул: <?= $model->code_number ?></span>

                <span class="price"><?= Yii::$app->formatter->asCurrency($model->price, 'RUR') ?></span>
                <?php
                $max_quantity = Yii::$app->params['exist_in_market_max_quantity'];
                $percent = floor(($model->quantity * 100) / $max_quantity);
                $percent = $percent > 100 ? 100 : $percent ;
                ?>
                <p class="quantity-exist">есть в наличии <span class="img-quantity"><span class="real-quantity" style="width: <?=$percent?>%;"></span></span></p>

                <div class="add-to-cart">
                    <div class="quantity">
                        <a href="#" class="minus">-</a>
                        <input type="text" name="quantity" maxlength="2" value="1"/>
                        <a href="#" class="plus">+</a>
                    </div>
                    <noindex><?= Html::a('В корзину', ['/add-to-cart', 'id' => $model->id], ['class' => 'add-to-cart-button add-to-cart-blue', 'rel' => 'nofollow']) ?></noindex>
                    <noindex><?= Html::a('Быстрый заказ', ['/fast-order', 'id' => $model->id], ['class' => 'fast-order', 'rel' => 'nofollow']) ?></noindex>
                    <?php
                    if (!Yii::$app->user->isGuest) {
                    ?>
                        <noindex><?= Html::a('Отложить на потом', ['/add-to-wish-list', 'id' => $model->id], ['class' => 'wish-list-link']);?></noindex>
                    <?php
                    }
                    ?>

                </div>

                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1" style="margin-right: 5px;">
                        <span class="rating" style="line-height: 12px; "> Рейтинг:</span>
                    </div>
                    <div class="col-lg-10" >
                        <?=
                        \kartik\widgets\StarRating::widget([
                            'name' => 'rate_product',
                            'value' => $model->getRateValue(),
                            'pluginOptions' => [
                                'glyphicon' => false,
                                'step' => 1,
                                'size' => 'sm',
                                'disabled' => true,
                                'showCaption' => false,
                                'showClear' => false,
                                'symbol' => mb_convert_encoding("&#9632;", 'UTF-8', 'HTML-ENTITIES')
                            ]]);?>
                    </div>
                </div>


                <p class="description">
                    <?= $model->description ?>
                </p>
                <?=\frontend\modules\compare\widget\CompareWidget::widget([
                    'product' => $model
                ])?>
            </div>
            <div class="col-lg-12 ">
                <div class="product-description">
                    <div class="col-lg-9 no-padding-no-margin">
                        <?php
                        echo \yii\jui\Tabs::widget([
                            'items' => [
                                [
                                    'label' => 'Характеристики',
                                    'content' => $this->render('_product_property', ['model' => $model]),
                                ],
                                [
                                    'label' => 'Обзор',
                                    'content' => "<div class='text'>".$model->overview."</div>",
                                ],
                                [
                                    'label' => 'Отзывы ('.count($model->comments).")",
                                    'content' => $this->render('_comments', ['model' => $model]),
                                ]
                            ],
                            'options' => ['tag' => 'div'],
                            'itemOptions' => ['tag' => 'div'],
                            'headerOptions' => ['class' => 'my-class'],
                            'clientOptions' => ['collapsible' => false],
                        ]);
                        ?>
                    </div>
                    <div class="col-lg-3 no-padding-no-margin">
                        <?php
                        echo \frontend\modules\catalog\widgets\RenderPromotionProductWidget::widget([
                            'view_type' => \frontend\modules\catalog\widgets\RenderPromotionProductWidget::VIEW_VERTICAL,
                            'models' => $model->relProductModels,
                            'title' => 'Похожие модели'
                        ]);
                        ?>
                    </div>
                </div>


            </div>

        </div>

    </div>

</div>
