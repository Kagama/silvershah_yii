<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerAssetBundle('backend\assets\FileUploadAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\catalog\models\search\ProductSearch $searchModel
 */

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index padding020">
    <section class="widget">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => ['class' => 'table table-striped dataTable', 'aria-describedby' => "datatable-table_info", 'id' => 'datatable-table'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'code_number',
                'model',
                'manufacture_id',
                'name',
                // 'alt_name',
                // 'h1_name',
                // 'description:ntext',
                // 'old_price',
                // 'price',
                // 'quantity',
                // 'product_type_id',
                // 'visible',
                // 'seo_title',
                // 'seo_keywords',
                // 'seo_description',
                // 'rate',
                // 'rate_count',
                // 'pre_order',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </section>
</div>
