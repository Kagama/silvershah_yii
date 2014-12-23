<?php

use yii\helpers\Html;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var common\modules\order\models\OrderStatus $model
 */

$this->title = 'Обновить статус заказа: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статус заказа', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="order-status-update padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
