<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.07.14
 * Time: 15:26
 */
use yii\helpers\Html;

?>
<?= Html::a(Html::img($model->photos[0]->doCache('178x178', 'auto', '168x168')), ['/product/' . $model->code_number], ['class' => 'img-link']) ?>
<div class="description">
    <?= Html::a(\common\helpers\CString::subStr($model->h1_name, 0, 50), ['/product/' . $model->code_number], ['class' => 'link']) ?>
    <?= Html::tag('span', "Артикул: ".$model->code_number); ?>
    <?= Html::tag('p', $model->description); ?>
</div>
<div class="price-add-to-cart-compare">
    <?= Html::tag('span', Yii::$app->formatter->asCurrency($model->price, 'RUR'), ['class' => 'price']) ?>
    <div class="add-to-cart">
        <div class="quantity">
            <a href="#" class="minus">-</a>
            <input type="text" name="quantity" maxlength="2" value="1" readonly=true/>
            <a href="#" class="plus">+</a>
        </div>
        <noindex><?= Html::a('В корзину',['/add-to-cart', 'id' => $model->id], ['class' => 'add-to-cart-button add-to-cart-blue', 'rel' => 'nofollow']) ?></noindex>
    </div>
    <noindex><?= Html::a('Добавить к сравнению', ["/add-to-compare", 'id' => $model->id], ['class' => 'add-to-compare', 'rel' => 'nofollow']) ?></noindex>
</div>
