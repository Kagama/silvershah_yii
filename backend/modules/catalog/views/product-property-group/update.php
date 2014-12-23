<?php

use yii\helpers\Html;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductProperty $model
 */

$this->title = 'Обновить группу: ' . $model->frontend_name;
$this->params['breadcrumbs'][] = ['label' => 'Группа свойств', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->frontend_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="product-property-update padding020">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
