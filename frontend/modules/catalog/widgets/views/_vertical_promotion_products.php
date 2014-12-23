<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.07.14
 * Time: 20:54
 */
use yii\helpers\Html;
?>
<h2 style="font-size: 16px; color:#808080; text-align: center; font-family: 'Roboto', sans-serif;"><?=$title ?></h2>

<div class="promo-products-list-vertical">
<?php
foreach ($models as $model) {
?>
    <div class="prod-item">
        <?= Html::a(Html::img("/".$model->photos[0]->doCache('260x260', 'auto', '140x140'), ['alt' => $model->name]), ['/product/' . $model->code_number], ['class' => 'link']) ?>
        <?= Html::a(\common\helpers\CString::subStr($model->h1_name, 0, 50), ['/product/' . $model->code_number], ['class' => 'prod-link']) ?>
        <?= Html::tag('span', Yii::$app->formatter->asCurrency($model->price, 'RUR'), ['class' => 'price'])?>
<!--        <noindex>--><?//= Html::a('В корзину',['/add-to-cart', 'id' => $model->id], ['class' => 'add-to-cart-blue', 'rel' => 'nofollow']) ?><!--</noindex>-->
    </div>
<?php
}
?>
</div>