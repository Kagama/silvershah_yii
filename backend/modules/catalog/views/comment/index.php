<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\catalog\models\search\ProductCommentSearch $searchModel
 */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-comment-index padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?//= //Html::a('Create Product Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',
            'username',
            'text:ntext',
//            'product_id',
            // 'date',
            // 'like_count',
            // 'unlike_count',
            // 'product_id',
            // 'approve',
            // 'level',
            // 'rate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
