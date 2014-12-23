<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductSlider $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Слайдер', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-slider-view padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать слайд', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'active',
                'value' => $model->active == 0 ? "Нет" : "Да",
            ],
            [
                'attribute' => 'img_name',
                'value' => Html::img("/".$model->src."/".$model->img_name),
                'format' => 'html'
            ],
//            'img_name:img',
//            'src',
            'href:url'
        ],
    ]) ?>

</div>
