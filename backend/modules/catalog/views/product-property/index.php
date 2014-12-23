<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\modules\catalog\models\ProductPropertyGroup;


$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\catalog\models\search\ProductPropertySearch $searchModel
 */

$this->title = 'Свойство продукта';
$this->params['breadcrumbs'][] = $this->title;

$ProductPropertySearch = Yii::$app->request->get('ProductPropertySearch');
?>
<div class="product-property-index padding020">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <section class="widget">
        <p>
            <?= Html::a('Создать свойство продукта', ['create', 'group_id' => $ProductPropertySearch['group_id'] ], ['class' => 'btn btn-success']) ?>
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
                'title',
                [
                    'attribute' => 'group_id',
                    'value' => function($data) {
                           return (empty($data->group->frontend_name) ? "---" : $data->group->frontend_name);
                        },
                    'format' => 'html',
                    'filter' => ArrayHelper::map(ProductPropertyGroup::find()->all(), "id", "frontend_name")
                ],
                [
                    'attribute' => 'is_visible_to_filter',
                    'value' => function($data) {
                            return $data->is_visible_to_filter == 1 ? "<span style='color:#00CC00;'>Отображать</span>" : "<span style='color:#D40000;'>Не отображать</span>";
                        },
                    'format' => 'html',
                    'filter' => [0 => 'Не отображать', 1 => 'Отобразить']
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </section>
</div>
