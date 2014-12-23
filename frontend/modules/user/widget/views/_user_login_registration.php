<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.08.14
 * Time: 17:31
 */
use yii\web\View;
use yii\helpers\Html;
use common\modules\user\models\User;
?>

<noindex>
    <?php
    if (Yii::$app->user->isGuest) {
        echo Html::a('Вход', ['/login'], ['rel' => 'nofollow', 'class' => 'login']);
        echo " &nbsp;|&nbsp; ";
        echo Html::a('Регистрация', ['/registration'], ['rel' => 'nofollow', 'class' => 'registration']);
    } else {
        echo Html::a(\common\helpers\CString::subStr(User::getUserName(), 0, 18, ' ') , ['/cabinet'], ['rel' => 'nofollow', 'class' => 'welcome-link']);
        echo " &nbsp;|&nbsp; ";
        echo Html::a('Выход', ['/logout'], ['rel' => 'nofollow', 'class' => 'logout']);
    }
    ?>
    <div class="user-content-block">
    </div>
</noindex>

