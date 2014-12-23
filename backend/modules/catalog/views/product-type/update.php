<?php

use yii\helpers\Html;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductType $model
 */

$this->title = 'Обновить тип продукта: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Тип продукта', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="product-type-update padding020">

    <h1><?= Html::encode($this->title) ?></h1>

        <?=
        $this->render('_form', [
            'model' => $model,
        ]) ?>

</div>
