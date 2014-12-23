<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\modules\order\models\search\OrderSearch $searchModel
 */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-index padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
<!--        --><?//= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'user_id',
                'value' => function ($model, $index) {
                        return $model->user->phone;
                    }
            ],
            [
                'attribute' => 'status',
                'value' => function ($model, $index) {
                        $html = "<span";
                        $style = "";
                        if ($model->statusName->name == 'Новый') {
                            $style = " class='label label-success' ";
                        }
                        if ($model->statusName->name == 'В обработке') {
                            $style = " class='label label-warning' ";
                        }
                        if ($model->statusName->name == 'Доставка') {
                            $style = " class='label label-primary' ";
                        }
                        if ($model->statusName->name == 'Завершён') {
                            $style = " class='label label-success' ";
                        }
                        if ($model->statusName->name == 'Приостановлен') {
                            $style = " class='label label-info' ";
                        }
                        if ($model->statusName->name == 'Отказ') {
                            $style = " class='label label-default' ";
                        }
                        if ($model->statusName->name == 'Возврат') {
                            $style = " class='label label-danger' ";
                        }
                        $html .= $style.">".$model->statusName->name."</span>";
                        return $html;
                    },
                'filter' => \yii\helpers\ArrayHelper::map(\common\modules\order\models\OrderStatus::find()->all(), 'id', 'name'),
                'format' => 'html'
            ],
            'date:date',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>

</div>
