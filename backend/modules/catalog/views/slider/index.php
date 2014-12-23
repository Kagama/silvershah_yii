<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\catalog\models\search\ProductSliderSearch $searchModel
 */

$this->title = 'Слайдер';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-slider-index padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать слайд', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'img_name',
                'value' => function ($model, $index) {
                        return Html::img("/".$model->doCache('200x200', 'height'));
                    },
                'filter' => false,
                'format' => 'html',
            ],
            'id',
            'name',
            [
                'attribute' => 'active',
                'value' => function ($model, $index) {
                        return $model->active == 0 ? "Нет" : "Да";
                    },
                'filter' => ['Нет', "Да"],
                'format' => 'html'
            ],

//            'img_name',
//            'src',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
