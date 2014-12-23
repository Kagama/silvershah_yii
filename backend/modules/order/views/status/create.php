<?php

use yii\helpers\Html;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var common\modules\order\models\OrderStatus $model
 */

$this->title = 'Создать статус';
$this->params['breadcrumbs'][] = ['label' => 'Статус заказа', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-status-create padding020 widget">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
