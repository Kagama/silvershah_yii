<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.09.14
 * Time: 19:37
 */
use yii\helpers\Html;
use yii\web\View;

Yii::$app->view->registerJs("



", View::POS_READY);
?>
<?php

if (empty($products)) {
    ?>
    <div class="col-lg-12 just-sell-block">
        <span class="block-title">Только что проданно</span>

        <div class="just-sell">

            <a href="javascript:void();" class="left">&nbsp;</a>
            <a href="javascript:void();" class="right">&nbsp;</a>

            <div class="content">
                <ul>
                    <?php

                    foreach ($products as $product) {
                        ?>
                        <li>
                            <?php
                            if (!empty($product->photos[0])) {
                                ?>
                                <img src="/<?= $product->photos[0]->doCache('68x53', 'auto', '68x53'); ?>"
                                     alt="Фото - <?= $product->h1_name ?>"/>
                            <?php
                            }
                            ?>
                            <div class="prod-info">
                                <?= Html::a($product->h1_name, ['/product/' . $product->code_number]) ?>
                                <span
                                    class="price"><?= Yii::$app->formatter->asCurrency($product->price, 'RUR') ?></span>
                                <!--                            <span class="time">1ч. 3 мин.</span>-->
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php
}
?>