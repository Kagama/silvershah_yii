<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 26.08.14
 * Time: 15:40
 */
$this->params['breadcrumbs'] = [
    ['label' => 'Кабинет пользователя', 'url' => null],
];

$new_orders_count = count($orders);
$history_orders_count = \common\modules\order\models\Order::find()->where('status <> 1 and user_id = :id', [':id' => Yii::$app->user->getId()])->count();
$route = Yii::$app->controller->route;
?>
<div class="row no-padding-no-margin user-cabinet content-block-top-shadow" style="background-color: #fff">
    <div class="align-center">
        <div class="row no-padding-no-margin">

            <div class="col-lg-9 no-padding-no-margin">
                <div style="font-size: 12px;">
                    <?=
                    \yii\widgets\Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'encodeLabels' => false
                    ]) ?>
                </div>
                <h1>Личный кабинет пользователя - <span><?= \common\modules\user\models\User::getUserName() ?></span>
                </h1>
                <?php
                if ($render_template == 'wish-list') {
                    echo "<h2>Отложенные товары</h2>";
                    echo $this->render('_' . $render_template, [
                        'wishObj' => $wishObj
                    ]);
                }
                if ($render_template == 'index') {
                    echo "<h2>Текущие заказы</h2>";
                    echo $this->render('_' . $render_template, [
                        'orders' => $orders
                    ]);
                }
                if ($render_template == 'history') {
                    echo "<h2>История заказов</h2>";
                    echo $this->render('_' . $render_template, [
                        'orders' => $orders
                    ]);
                }
                if ($render_template == 'profile') {
                    echo "<h2>Информация о профиле</h2>";
                    echo $this->render('_' . $render_template, [
                        'model' => $user
                    ]);
                }
                if ($render_template == 'change_password') {
                    echo "<h2>Сменить пароль</h2>";
                    echo $this->render('_' . $render_template, [
                        'model' => $user
                    ]);
                }

                ?>

            </div>
            <div class="col-lg-3 no-padding-no-margin">
                <span class="title">Настройки профиля</span>
                <ul class="menu-list-white">
                    <li <?= ($route == 'user/cabinet/profile' ? "class='active'" : "") ?>><a
                            href="<?= \yii\helpers\Url::to(['/user/cabinet/profile']) ?>">Информация о профиле</a></li>
                    <li <?= ($route == 'user/cabinet/change-password' ? "class='active'" : "") ?>><a
                            href="<?= \yii\helpers\Url::to(['/user/cabinet/change-password']) ?>">Сменить пароль</a>
                    </li>
                </ul>
                <span class="title">Ваши заказы</span>
                <ul class="menu-list-white">
                    <li <?= ($route == 'user/cabinet/index' ? "class='active'" : "") ?>><a
                            href="<?= \yii\helpers\Url::toRoute(['/cabinet']) ?>">Текущие
                            заказы</a> <?= ($new_orders_count != 0 ? "(" . $new_orders_count . ")" : "") ?></li>
                    <li <?= ($route == 'user/cabinet/history' ? "class='active'" : "") ?>><a
                            href="<?= \yii\helpers\Url::toRoute(['/user/cabinet/history']) ?>">История
                            заказов</a> <?= ($history_orders_count != 0 ? "(" . $history_orders_count . ")" : "") ?>
                    </li>
                    <li <?= ($route == 'user/cabinet/wish-list' ? "class='active'" : "") ?>><a href="<?= \yii\helpers\Url::toRoute(['/user/cabinet/wish-list']) ?>">Отложенные
                            товары</a></li>
                </ul>

            </div>
        </div>
    </div>
</div>