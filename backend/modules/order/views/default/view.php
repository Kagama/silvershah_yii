<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var common\modules\order\models\Order $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'status',
                'value' => $html = "<span".(
                        ($model->statusName->name == 'Новый') ? " class='label label-success' " :
                            ($model->statusName->name == 'В обработке') ? " class='label label-warning' " :
                                ($model->statusName->name == 'Доставка') ? " class='label label-primary' " :
                                    ($model->statusName->name == 'Завершён') ? " class='label label-success' " :
                                        ($model->statusName->name == 'Приостановлен') ? " class='label label-info' " :
                                            ($model->statusName->name == 'Отказ') ? " class='label label-default' " :
                                                ($model->statusName->name == 'Возврат') ? " class='label label-danger' " : ""
                        ).">".$model->statusName->name."</span>",
                'format' => 'html'
            ],
            'date:date',
        ],
    ]) ?>

</div>
