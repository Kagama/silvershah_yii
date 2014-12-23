<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.08.14
 * Time: 17:17
 */
use yii\helpers\Html;

?>
<?php

if (!empty($promoBlocks)) {

    ?>
    <div class="col-lg-4 no-padding-no-margin" style="width: 30%;">
        <?php
        foreach ($promoBlocks as $promo) {
            ?>
            <div class="product-of-the-day">
                <span class="title"><?= $promo->name ?></span>

                <div class="text-center">
                    <?php
                    foreach ($promo->promoProdRel as $rel) {
                        ?>
                        <?= Html::a(Html::img("/" . $rel->product->photos[0]->doCache('200x136', 'auto', '200x136'), ['alt' => $rel->product->name]), ['/product/' . $rel->product->code_number], ['class' => 'link']) ?>
                        <?= Html::a(\common\helpers\CString::subStr($rel->product->h1_name, 0, 50), ['/product/' . $rel->product->code_number], ['class' => 'prod-link']); ?>

                        <div class="row no-padding-no-margin" style="margin: 0 9%;">
                            <div class="col-lg-6 text-left no-padding-no-margin">
                                <?php
                                $price = $rel->product->priceWithDiscount();
                                if ($price != null) {
                                    ?>
                                    <span class="old-price">
                                <s><?= Yii::$app->formatter->asCurrency($rel->product->price, 'RUR') ?></s>
                            </span>
                                    <?php
                                    $price = Yii::$app->formatter->asCurrency($price, 'RUR');
                                    ?>
                                    <span class="price" <?= strlen($price) > 9 ? "style='font-size:24px;'" : "" ?>>
                                <?= $price ?>
                            </span>
                                <?php
                                } else {
                                    ?>
                                    <?php
                                    $price = Yii::$app->formatter->asCurrency($rel->product->price, 'RUR');
                                    ?>
                                    <span class="old-price"></span>
                                    <span
                                        class="price" <?= strlen($price) > 9 ? "style='font-size:24px;'" : "" ?>><?= $price ?></span>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="col-lg-6 no-padding-no-margin">
                                <noindex><?= Html::a('В корзину', ['/add-to-cart', 'id' => $rel->product->id], ['class' => 'add-to-cart-button add-to-cart-red', 'rel' => 'nofollow']) ?></noindex>
                            </div>
                        <span class="col-lg-12 left-prod-count no-padding-no-margin text-left">
                            Осталось <strong><?= $rel->product->quantity; ?> шт.</strong>
                        </span>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
        <?php
        }
        ?>
    </div>
<?php
}
?>
