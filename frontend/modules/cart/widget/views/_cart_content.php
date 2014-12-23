<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.08.14
 * Time: 13:41
 */
use yii\helpers\Html;
use yii\web\View;

Yii::$app->view->registerJs('

    $(document).on("click", ".create-order", function() {
        form = $(document).find(".create-order-form");
        $.ajax({
            type: "get",
            url: $(form).attr("action"),
            dataType: "json",
            success: function (json) {
                $(".cart-section .container").replaceWith(json.html);
            }
        });
    });
    $(document).on("click", ".do-create-order", function() {
        form = $(document).find(".create-order-form");
        $.ajax({
            type: "post",
            url: $(form).attr("action"),
            data: $(form).serialize(),
            dataType: "json",
            success: function (json) {
                if (json.error == false) {

                    setTimeout(function(){
                       window.location.reload(1);
                    }, 3000);

                }
                $(".cart-section .container").replaceWith(json.html);

            }
        });
    });

    // Удаление товар с корзины.
    $(document).on("click", ".cart-del", function(){
        var _href = $(this).attr("var-href");
        var _parent_tr = $(this).parent("td").parent("tr");
        if (confirm("Вы действительно хотите удалить товар из корзины?")) {

            $.ajax({
                type:"GET",
                url:_href,
                dataType:"json",
                success:function(result) {
                    if (result.error == false) {
                        $(_parent_tr).slideUp(1000);

                        $(".counter .num").empty();
                        $(".counter .num").html(result.total.quantity);

                        $(".opt .cart span.count").html(result.total.quantity);

                        $(".counter .sum").empty();
                        $(".counter .sum").html(result.total.price);
                    }
                    if (result.error == true) {
                        alert(result.message);
                    }
                }
            });
        }
        return false;
    });

    // Изменение количества товара в корзине
    // Увеличение количества товара
    $(document).on("click", ".table table .cart-add", function(){
        var _input  = $(this).prev("input");
        var _quantity = parseInt($(_input).val());
        var _prod_id = parseInt($(this).attr("var-prod-id"));

        if ((_quantity + 1)> 99) {
            alert("Вы уже добавили максимальное количество товаров.");
        } else {
            _quantity = _quantity + 1;
            $.ajax({
                type:"get",
                url:"' . \yii\helpers\Url::to(['/add-to-cart']) . '",
                data:{id:_prod_id, quantity: 1},
                dataType:"json",
                success: function(result) {
                    if (result.error == false) {

                        $(".opt .cart span.count").html(result.total.quantity);
                        $(".counter .num").empty();
                        $(".counter .num").html(result.total.quantity);
                        $(".counter .sum").empty();
                        $(".counter .sum").html(result.total.price);

                        // подсчет общей суммы
                        var _item_price = $(_input).parent("td").next("td").children(".cart-one-item").html();
                        var _total_sum = $(_input).parent("td").next("td").next("td").children(".cart-calc-price");
                        $(_total_sum).html(parseInt(_item_price * result.product_quantity));

                        $(_input).val(_quantity);
                    }
                    if (result.error == true) {
                        alert(result.message);
                    }
                }
            });
        }
    });
    // Уменьшение количества товара
    $(document).on("click", ".table table .cart-sub", function(){
        var _input  = $(this).next("input");
        var _quantity = parseInt($(_input).val());
        var _prod_id = parseInt($(this).attr("var-prod-id"));

        if ((_quantity - 1) < 1) {

        } else {
            _quantity = _quantity - 1;
            $.ajax({
                type:"get",
                url:"' . \yii\helpers\Url::to(['/cart-remove']) . '",
                data:{id:_prod_id},
                dataType:"json",
                success: function(result) {
                    if (result.error == false) {

                        $(".opt .cart span.count").html(result.total.quantity);
                        $(".counter .num").empty();
                        $(".counter .num").html(result.total.quantity);
                        $(".counter .sum").empty();
                        $(".counter .sum").html(result.total.price);

                        // подсчет общей суммы
                        var _item_price = $(_input).parent("td").next("td").children(".cart-one-item").html();
                        var _total_sum = $(_input).parent("td").next("td").next("td").children(".cart-calc-price");
                        $(_total_sum).html(parseInt(_item_price * result.product_quantity));

                        $(_input).val(_quantity);
                    }
                    if (result.error == true) {
                        alert(result.message);
                    }
                }
            });
        }
    });

', View::POS_END, 'cart-content-manager');

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
    <h1>Корзина</h1>

    <div class="counter">
        <span class="num"><?= $cart->getTotalQuantity() ?></span>
        <span>товаров на сумму</span>
        <span class="sum"><?= $cart->getTotalSum() ?></span>
        <span>рублей</span>
        <?=Html::buttonInput("оформить заказ", ['class' => 'create-order'])?>
    </div>

    <div class="table">
        <table>
            <?php
            foreach ($cart->items as $item) {
                $product = \common\modules\catalog\models\Product::findOne((int)$item['id']);
                if ($product == null) continue;
                ?>
                <tr>
                    <td>
                        <?php
                        if (!empty($product->photos)) {
                            ?>
                            <?= Html::img("/" . $product->photos[0]->doCache('100x100', 'auto')) ?>
                        <?php
                        }
                        ?>
                    </td>
                    <td><?= $product->code_number ?></td>
                    <td><?= $product->h1_name ?></td>
                    <td>
                        <div class="cart-sub" var-prod-id="<?= $item['id'] ?>">-</div>
                        <input class="cart_counter" type="text" value="<?= $item['quantity'] ?>">
                        <div class="cart-add" var-prod-id="<?= $item['id'] ?>">+</div>
                    </td>
                    <td><span class="cart-one-item"><?= $item['price'] ?></span></td>
                    <td><span class="cart-calc-price"><?= ($item['quantity'] * $item['price']) ?>0</span></td>
                    <td><img class="cart-del" src="/img/cart-del.png" alt=""
                             var-href="<?= \yii\helpers\Url::to(['/cart/delete', 'id' => $item['id']]) ?>"></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <?php \yii\widgets\ActiveForm::end() ?>

</div>
