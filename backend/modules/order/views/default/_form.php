<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\order\models\Order $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="order-form">
    <div class="content container no-margin" style="padding: 0; margin: 0;">

        <div class="row">
            <div class="col-md-8">
                <section class="widget">
                    <div class="body">
                        <div class="row">
                            <div class="col-sm-3">
                                <?=
                                $form->field($model, 'status')->dropDownList(
                                    \yii\helpers\ArrayHelper::map(\common\modules\order\models\OrderStatus::find()->all(), 'id', 'name'),
                                    ['prompt' => '---']) ?>
                            </div>
                            <div class="col-sm-3">
                                <?=
                                $form->field($model, 'date', [
                                    'template' => '
                                        <div>{label}</div>
                                        <label style="font-size: 22px; padding: 8px ;" class="label label-danger">' . date("d.m.Y", $model->date) . '</label>
                                        {input}
                                        {error}
                                    '
                                ])->hiddenInput() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h2>В корзине</h2>
                            </div>
                            <div class="col-lg-6 text-right">
                                <?=Html::a('Скачать .xls файл заказа', ['/order/default/order-xls', 'id' => $model->id], ['style' =>'color:#fff; font-size:12px; padding:5px 10px 5px 10px; margin-top:25px; ', 'class' => 'label label-success'])?>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="hidden-xs">Фото</th>
                                <th>Артикул:Название продукта</th>
                                <th>Количество</th>
                                <th class="hidden-xs">Стоимость 1 шт.</th>
                                <th>Цена</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $totalPrice = 0;
                            foreach ($model->cart->cartItems as $index => $item) {
                                $totalPrice += floatval(($item->quantity * $item->price));
                                ?>
                                <tr>
                                    <td class="text-align-center"><?= ($index + 1) ?></td>
                                    <td class="hidden-xs text-align-center"><?= (isset($item->product->photos[0]) ? Html::img("/" . $item->product->photos[0]->doCache('70x70', 'width', '50x50')) : ""); ?></td>
                                    <td><?= "<strong>" . $item->product->code_number . "</strong> : " . $item->product->h1_name; ?></td>
                                    <td><?= $item->quantity ?></td>
                                    <td class="hidden-xs"><?= Yii::$app->formatter->asCurrency($item->price, 'RUR') ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency(($item->quantity * $item->price), 'RUR') ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-6 col-print-6">

                            </div>
                            <div class="col-sm-6 col-print-6 ">
                                <div class="row text-align-right">
                                    <div class="col-xs-5"></div>
                                    <!-- instead of offset -->
                                    <div class="col-xs-3">
                                        <!--                    <p>Итого</p>-->
                                        <!--                    <p>Tax(10%)</p>-->
                                        <p class="no-margin"><strong>Итого</strong></p>
                                    </div>
                                    <div class="col-xs-3">
                                        <!--                    <p>1,598.88</p>-->
                                        <!--                    <p>159.89</p>-->
                                        <p class="no-margin">
                                            <strong><?= Yii::$app->formatter->asCurrency($totalPrice, 'RUR') ?></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-print-12">
                                <h2>Информация доставки</h2>

                                <?=$form->field($delivery, 'flp')->textInput(['value' => $model->user->username])?>
                                <?=$form->field($delivery, 'phone')->textInput(['value' => $model->user->phone])?>

                                <?=$form->field($delivery, 'address')->textInput()?>
<!--                                --><?//= $form->field($delivery, 'time')->textInput(['class' => 'date-picker2 form-control', 'style' => 'width:90px;']); ?>
<!--                                <script type="text/javascript">-->
<!--                                    $(document).ready(function () {-->
<!--                                        $('.date-picker2').datepicker({-->
<!--                                            format: "dd-mm-yyyy"-->
<!---->
<!--                                        });-->
<!--                                    });-->
<!--                                </script>-->
                                <?=$form->field($delivery, 'description')->textarea()?>
                                <?=$form->field($delivery, 'order_id')->hiddenInput()->label("")?>

                            </div>
                        </div>

                        <div class="form-actions">
                            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="widget">
                    <div class="body">
                        <h3><i class="fa fa-user"></i> Покупатель</h3>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="control-group">
                                    <label class="control-label" for="basic">Имя пользователя:</label>

                                    <div class="controls form-group">
                                        <span style="font-weight: bold; font-size: 14px;"><?= $model->user->username ?></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="basic">EMail:</label>

                                    <div class="controls form-group">
                                        <span style="font-weight: bold; font-size: 14px;"><?= $model->user->email; ?></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="basic">Контактный номер телефона:</label>

                                    <div class="controls form-group">
                                        <span style="font-weight: bold; font-size: 14px;"><?= $model->user->phone; ?></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="basic">Роль пользователя:</label>

                                    <div class="controls form-group">
                                        <span style="font-weight: bold; font-size: 14px;"><?= $model->user->userRole->name; ?></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="control-label" for="basic">Общее количество заказов:</label>

                                            <div class="controls form-group">
                                                <span style=" font-size: 22px; padding: 8px ;" class="label label-danger"><?= $model->user->ordersCount(); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label" for="basic">Общая стоимость заказов:</label>

                                            <div class="controls form-group">
                                                <span style=" font-size: 18px; padding: 8px ;" class="label label-danger"><?= $model->user->totalOrdersPrice(); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>

</div>
<?php ActiveForm::end(); ?>
