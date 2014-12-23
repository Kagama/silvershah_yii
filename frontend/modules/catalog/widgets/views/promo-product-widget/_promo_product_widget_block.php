<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.07.14
 * Time: 15:53
 */

use yii\helpers\Html;
?>
<?php
foreach ($promoBlocks as $promo) {
?>
<div class="row no-padding-no-margin promo-products-block">
        <span
            class="title"><?= $promo->name ?></span>
    <?php

    foreach ($promo->promoProdRel as $rel) {
        ?>
        <div class="prod-item">
            <?= Html::a(Html::img("/".$rel->product->photos[0]->doCache('100x100', 'auto', '100x100'), ['alt' => $rel->product->name]), ['/product/' . $rel->product->code_number], ['class' => 'link']) ?>
            <?= Html::a(\common\helpers\CString::subStr($rel->product->h1_name, 0, 50), ['/product/' . $rel->product->code_number], ['class' => 'prod-link']); ?>
            <!--                --><? //= Html::tag('span', Yii::$app->formatter->asCurrency($rel->product->price, 'RUR'), ['class' => 'price']) ?>
            <!--                <noindex>-->
            <? //= Html::a('В корзину', ['/add-to-cart', 'id' => $rel->product->id], ['class' => 'add-to-cart-button add-to-cart-blue', 'rel' => 'nofollow']) ?><!--</noindex>-->
        </div>
    <?php
    }

    }
    ?>
    <div class="clear-fix"></div>
    <div style="text-align: right; margin-top: 10px;">
        <?= Html::a('Просмотреть все »', ['/promotion-products/' . $promo->id . "_" . $promo->alt_name], ['class' => 'review-all']) ?>
    </div>
</div>
