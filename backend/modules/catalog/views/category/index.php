<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\widget\TreeViewWidget;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider models$dataProvider
 * @var common\modules\catalog\models\search\ProductCategorySearch $searchModel
 */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="product-category-index padding020">
    <section class="widget">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?=
        TreeViewWidget::widget([
            'model' => new \common\modules\catalog\models\ProductCategory(),
            'data' => $models,
            'options' => ['style' => 'width:100%;', 'class' => 'table table-bordered'],
            'columns' => [
                'id',
                'name',
                'position' => [
                    'field' => TreeViewWidget::INPUT_TEXT,
                    'ajaxUpdateUrl' => \yii\helpers\Url::to(['/catalog/category/update-position']),
                    'options' => ['style' => 'width:40px;', 'maxlength' => '3', 'class' => 'position_input_update']
                ]
            ],
            'buttons' => [
                'update' => [
                    'title' => '<i class="fa fa-pencil"></i>',
                    'url' => '/catalog/category/update',
                    'options' => ['class' => 'btn btn-default btn-xs']

                ],
                'view' => [
                    'title' => '<i class="fa fa-search"></i>',
                    'url' => '/catalog/category/view',
                    'options' => ['class' => 'btn btn-primary btn-xs']
                ],
                'delete' => [
                    'title' => '<i class="fa fa-trash-o"></i>',
                    'url' => '/catalog/category/delete',
                    'options' => ['class' => 'btn btn-danger btn-xs', 'onclick' => 'return confirm("Вы действительно хотите удалить категорию?");']
                ]
            ]
        ]); ?>

    </section>
</div>
