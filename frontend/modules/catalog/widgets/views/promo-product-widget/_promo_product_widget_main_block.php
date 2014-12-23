<?php
use yii\helpers\Html;
use yii\web\View;

Yii::$app->view->registerJs('

    var _super_price_content_length = $(".super-price .content ul li").length;
    var _super_price_content_view = 3;
    var _super_price_click_number = 0;
    $(".super-price .left").on("click", function () {

        if (_super_price_content_view < (_super_price_click_number + _super_price_content_view)) {

            $( ".super-price .content ul li" ).animate({ "left": "+=201px" }, "slow" );
            _super_price_click_number = _super_price_click_number - 1;
        }
        return false;
    });

    $(".super-price .right").on("click", function () {

        if (_super_price_content_length > (_super_price_click_number + _super_price_content_view)) {

            $( ".super-price .content ul li" ).animate({ "left": "-=201px" }, "slow" );
            _super_price_click_number = _super_price_click_number + 1;
        }

        return false;
    });

', View::POS_READY, 'main-promo-product-block-slider');

?>
<div class="col-lg-8 no-padding-no-margin super-price-block">
<?php
foreach ($promoBlocks as $promo) {
?>


    <div class="super-price">
        <span class="title"><?= $promo->name ?></span>
        <a class="left" href="#"></a>
        <a class="right" href="#"></a>
        <div class="content">
            <ul>
                <?php
                foreach ($promo->promoProdRel as $rel) {
                ?>
                <li class="text-center">
                    <?= Html::a(Html::img("/".$rel->product->photos[0]->doCache('180x136', 'auto', '180x136'), ['alt' => $rel->product->name]), ['/product/' . $rel->product->code_number], ['class' => 'link']) ?>

                    <?= Html::a(\common\helpers\CString::subStr($rel->product->h1_name, 0, 50), ['/product/' . $rel->product->code_number], ['class' => 'prod-link']); ?>

                    <div class="row no-padding-no-margin">
                        <div class="col-lg-6 text-left no-padding-no-margin">
                            <?php
                            $price = $rel->product->priceWithDiscount();
                            if ($price != null) {
                                ?>
                                <span class="old-price">
                                    <s><?=Yii::$app->formatter->asCurrency($rel->product->price, 'RUR')?></s>
                                </span>
                                <span class="price">
                                    <?=Yii::$app->formatter->asCurrency($price, 'RUR')?>
                                </span>
                            <?php
                            } else {
                            ?>
                                <span class="old-price"></span>
                                <span class="price"><?=Yii::$app->formatter->asCurrency($rel->product->price, 'RUR')?></span>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-lg-6 no-padding-no-margin">
                            <noindex><?= Html::a('В корзину', ['/add-to-cart', 'id' => $rel->product->id], ['class' => 'add-to-cart-button add-to-cart-red', 'rel' => 'nofollow']) ?></noindex>
                        </div>
                    </div>
                </li>
                <?php
                }
                ?>
                <div class="clearfix"></div>
            </ul>
        </div>

    </div>

<?php
}
?>
</div>
