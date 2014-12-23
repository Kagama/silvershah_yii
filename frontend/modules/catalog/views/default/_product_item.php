<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.07.14
 * Time: 15:26
 */
use yii\helpers\Html;

$main_img = "";

if (!empty($model->photos[0])) {
    if (($index % 9) == 0) {
        $main_img = "/" . $model->photos[0]->doCache('420x420', 'auto', '416x416');
    } else {
        $main_img = "/" . $model->photos[0]->doCache('180x180', 'auto', '180x180');
    }
}

if ($index == 0) {
    echo '<div class="item big left">';
} else {
    if ((($index % 18) == 0)) {
        echo '<div class="item big left">';

    } else if ((($index % 9) == 0)) {
        echo '<div class="item big right">';

    } else {
        echo '<div class="item">';
    }
}

?>
<?= Html::img($main_img) ?>
<span><? $model->h1_name ?></span>
<?php
//Yii::$app->formatter->asCurrency($model->price, 'RUR')
?>
<?= Html::tag('div', \common\helpers\CString::price($model->price), ['class' => 'price']) ?>
<a class="hov"
   href="<?= \yii\helpers\Url::to(['/' . $model->id . "/" . \common\helpers\CString::translitTo($model->h1_name)]) ?>">
    <!--<a class="hov" href="--><? //= \yii\helpers\Url::to(['/product/' . $model->id]) ?><!--">-->
    Подробнее
</a>
</div>

