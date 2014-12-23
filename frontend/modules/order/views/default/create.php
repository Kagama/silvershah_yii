<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.08.14
 * Time: 14:26
 */
//
//use yii\widgets\Breadcrumbs;
//
//$this->params['breadcrumbs'] = [
//    ['label' => 'Оформление заказа', 'url' => null]
//];
//
$this->title = "Оформление заказа - " . Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['seo_keywords']]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['seo_description']]);
?>


<div class="container">

    <?php $form = \yii\widgets\ActiveForm::begin([
        'method' => 'post',
        'id' => 'create-order',
        'action' => \yii\helpers\Url::to(['/create-order']),
        'options' => [
//            'data-pjax' => 'form1',
            'class' => 'create-order-form'
        ]
    ]); ?>
    <h1>Оформить заказ</h1>

    <div class="counter">
        <span class="num"><?= $cart->getTotalQuantity() ?></span>
        <span>товаров на сумму</span>
        <span class="sum"><?= $cart->getTotalSum() ?></span>
        <span>рублей</span>
        <?= \yii\helpers\Html::submitInput("Корзина") ?>
    </div>

    <div class="table">
        <?php if ($order_create) {
            ?>
        <div class="form">
            Спасибо <strong><?=$model->username?></strong> за Ваш заказ.<br />
            В ближайшее время мы рассмотрим Ваш заказа и свяжемся с Вами.
            <?php
            Yii::$app->session->remove('userCart');
            Yii::$app->view->registerMetaTag(['http-equiv' => 'Refresh', 'content' => '10; url='.\yii\helpers\Url::home()]);
            ?>
        </div>
        <?php
        } else {
            ?>
            <div class="form">
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'phone_number')->textInput([
                    'placeholder' => '+7(123)123-1234',
                ]) ?>
                <div style="text-align: center;">
                    <?= \yii\helpers\Html::buttonInput("Заказать", ['class' => 'do-create-order']) ?>
                </div>
            </div>
        <?php
        } ?>


    </div>
    <?php \yii\widgets\ActiveForm::end() ?>
</div>
