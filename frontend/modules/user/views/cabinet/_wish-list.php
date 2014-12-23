<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 04.09.14
 * Time: 20:23
 */
?>
<div style="padding-right: 30px;">
    <table class="cart-table">
        <thead>
        <tr>
            <th>Название</th>
            <th>Цена</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (empty($wishObj)) {
            ?>
            <tr>
                <td colspan="2" class="text-center">-- нет данных --</td>
            </tr>
        <?php
        } else {
            foreach ($wishObj as $wish) {
                ?>
                <tr>
                    <td class="product">
                        <div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <img src="/<?= $wish->product->photos[0]->doCache('100x100', 'width', '100x100'); ?>"
                                         alt="<?= $wish->product->name ?>">
                                </div>
                                <div class="col-lg-8">
                                    <?= \yii\helpers\Html::a($wish->product->h1_name, ['/product/' . $wish->product->code_number]); ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="price">
                        <?= Yii::$app->formatter->asCurrency($wish->product->price, 'RUR') ?>
                    </td>
                </tr>
            <?php
            }
        }
        ?>

        </tbody>
    </table>
</div>
