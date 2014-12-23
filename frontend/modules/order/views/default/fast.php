<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.08.14
 * Time: 14:26
 */

use yii\widgets\Breadcrumbs;
use yii\web\View;

$this->params['breadcrumbs'] = [
    ['label' => 'Оформление быстрого заказа', 'url' => null]
];

$this->title = "Оформление быстрого заказа - ".Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['seo_keywords']]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['seo_description']]);
?>
<div class="row no-padding-no-margin content-block-top-shadow"
     style="background-color: #fff; padding-bottom: 100px;">
    <div class="align-center">
        <div class="row order-content">
            <div class="col-lg-9 no-padding-no-margin">
                <div style="margin-right: 10px;">
                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <h1>Оформление заказа</h1>

                    <?php $form = \yii\widgets\ActiveForm::begin(); ?>
                    <?php
                    if (Yii::$app->session->hasFlash('order_success_create') &&
                        Yii::$app->session->getFlash('order_success_create') == true
                    ) {
                        $this->registerMetaTag(['http-equiv' => 'refresh', 'content' => '3;' . \yii\helpers\Url::home()]);
                        ?>
                        <div class="alert-success">
                            <strong>Спасибо, заказ сформирован.</strong> <br/><br/>
                            В ближайшее время наш менеджер свяжется с Вами для уточнения информации о заказе. <br/>
                            <?php
                            if (Yii::$app->session->hasFlash('order_reg_new_user') &&
                                Yii::$app->session->getFlash('order_reg_new_user') == true
                            ) {
                                ?>
                                В ближайшее время Вы получите СМС сообщение с паролем к Вашей учетной записи на нашем сайте.
                            <?php
                            }
                            ?>

                        </div>
                        <?php
                        Yii::$app->session->destroy();
                    }
                    ?>
                    <?=
                    \frontend\modules\cart\widget\CartContent::widget([
                        'type' => 'simple'
                    ]);?>


                    <p>Для оформления заказа введите Ваш номер моб. телефона в поле ниже. <br/>Наш оператор свяжется с
                        Вами
                        в ближайшее время.</p>
                    <?=
                    $form->field($model, 'phone_number', [
                        'template' => '
                        <div>{label}</div>
                        {input} ' . \yii\helpers\Html::submitButton('Заказать', ['class' => 'blue-small-button']) . '
                        {error}
                    '
                    ])->widget(\yii\widgets\MaskedInput::className(), [
                            'mask' => '+7(999)-999-9999',
                            'model' => $model,
                            'attribute' => 'phone_number',
                            'options' => [
                                'placeholder' => '+7(___)-___-____',
                                'class' => 'input-type-text-medium'
                            ]
                        ]); ?>
                    <?php \yii\widgets\ActiveForm::end() ?>
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


