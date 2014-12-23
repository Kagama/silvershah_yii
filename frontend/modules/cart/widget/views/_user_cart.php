<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.07.14
 * Time: 0:48
 */
use yii\helpers\Html;
?>
<div class="cart">
    <?php
    $countStr = (string) $cart->total['quantity'];
    $lastChar = $countStr{(strlen($countStr) - 1)};
    if ($lastChar == 1) {
        $str = 'тов.';
    } else if ( ($lastChar == 2 || $lastChar == 3 || $lastChar == 4) && strlen($countStr) < 2) {
        $str = "товара";
    } else {
        $str = "товаров";
    }

    if (empty($cart->items)) {
        echo '<span class="count">0</span>';
    } else {
        echo '<span class="count">'.$cart->total['quantity'].'</span>';
//        echo Html::a('В корзине '.$cart->total['quantity'].' тов.', ['/cart']);
    }
    ?>
</div>