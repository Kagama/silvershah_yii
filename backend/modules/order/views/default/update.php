<?php

use yii\helpers\Html;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var common\modules\order\models\Order $model
 */

$this->title = 'Обновить заказ: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="order-update padding020">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'delivery' => $delivery
    ]) ?>

</div>
