<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 26.08.14
 * Time: 16:39
 */
?>
<div style="padding-right: 30px;">
    <table class="cart-table" >
        <thead>
        <tr>
            <th>Номер и содержимое заказа</th>
            <th>Цена</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        if (empty($orders)) {
        ?>
            <tr>
                <td colspan="3" class="text-center">-- нет данных --</td>
            </tr>
        <?php
        } else {
            foreach ($orders as $order) {
                $order_price = 0;
                ?>
                <tr>
                    <td colspan="3">
                        <div style="font-size: 14px; padding-top: 20px;"><strong>Номер заказа:</strong> <?=$order->id?></div>
                    </td>
                </tr>
                <tr>
                    <td class="product">

                        <div>
                            <?php
                            foreach ($order->cart->cartItems as $item) {
                                $order_price = ($item->quantity * $item->price);
                                ?>
                                <div class="row">
                                    <div class="col-lg-1">
                                        <img src="<?= $item->product->photos[0]->doCache('50x50', 'width', '40x40'); ?>" alt="<?= $item->product->name ?>">
                                    </div>
                                    <div class="col-lg-8">
                                        <?= \yii\helpers\Html::a($item->product->h1_name, ['/product/' . $item->product->code_number]); ?>
                                    </div>
                                    <div class="col-lg-1">
                                        <strong><?=" Кол.:".$item->quantity;?></strong>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </td>
                    <td class="price">
                        <?php $total += $order_price?>
                        <?= Yii::$app->formatter->asCurrency($order_price, 'RUR') ?>
                    </td>
                    <td class="delete">

                        <?php
                        if ($order->statusName->name == 'Новый') {
                            $style = " class='label label-success' ";
                        }
                        if ($order->statusName->name == 'В обработке') {
                            $style = " class='label label-warning' ";
                        }
                        if ($order->statusName->name == 'Доставка') {
                            $style = " class='label label-primary' ";
                        }
                        if ($order->statusName->name == 'Завершён') {
                            $style = " class='label label-success' ";
                        }
                        if ($order->statusName->name == 'Приостановлен') {
                            $style = " class='label label-info' ";
                        }
                        if ($order->statusName->name == 'Отказ') {
                            $style = " class='label label-default' ";
                        }
                        if ($order->statusName->name == 'Возврат') {
                            $style = " class='label label-danger' ";
                        }
                        ?>
                        <span <?=$style?> ><?=$order->statusName->name?></span>

                    </td>
                </tr>
            <?php
            }
        }
        ?>

        </tbody>
        <tfoot>
        <tr class="total">
            <td class="text" colspan="2">Итого</td>
            <td class="price" colspan="3"><?= Yii::$app->formatter->asCurrency($total, 'RUR'); ?></td>
        </tr>
        </tfoot>
    </table>
</div>
