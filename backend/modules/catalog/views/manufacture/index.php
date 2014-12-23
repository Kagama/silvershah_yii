<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\FileHelper;

$this->registerAssetBundle('backend\assets\FileUploadAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\catalog\models\search\ManufactureSearch $searchModel
 */

$this->title = 'Производитель';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="manufacture-index padding020">
    <section class="widget">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать производителя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'table table-striped dataTable', 'aria-describedby' => "datatable-table_info", 'id' => 'datatable-table'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
//            'alt_name',
            'text:ntext',
            [
//                'attribute' => 'img',
                'filter' => false,
                'value' => function ($data) {
                        return Html::img($data->doCache("100x100"));
                    },
                'format' => 'html'
            ],
//            'img',
            // 'src',
            // 'seo_title',
            // 'seo_keywords',
            // 'seo_description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</section>
</div>
