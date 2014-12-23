<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\catalog\models\search\ProductPropertySearch $searchModel
 */

$this->title = 'Группа свойств';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-property-index padding020">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <section class="widget">
        <p>
            <?= Html::a('Создать группу', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => ['class' => 'table table-striped dataTable', 'aria-describedby' => "datatable-table_info", 'id' => 'datatable-table'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'backend_name',
                'frontend_name',
                [
                    'label' => 'Свойства продкта',
                    'value' => function($data) {
                        return Html::a('Просмотреть свойства', ['/catalog/product-property/index', 'ProductPropertySearch[group_id]' => $data->id]);
                    },
                    'format' => 'html',

                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </section>
</div>
