<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\catalog\models\search\ProductPromotionSearch $searchModel
 */

$this->title = 'Продвигаемая продукция';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-promotion-index padding020">
    <section class="widget">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Создать раздел', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => ['class' => 'table table-striped dataTable', 'aria-describedby' => "datatable-table_info", 'id' => 'datatable-table'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'alt_name',
                'position',
                'active',
                'discount',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </section>
</div>
