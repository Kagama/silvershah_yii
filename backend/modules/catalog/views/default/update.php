<?php

use yii\helpers\Html;
$this->registerAssetBundle('backend\assets\FileUploadAsset', \yii\web\View::POS_HEAD);
//$this->registerAssetBundle('backend\modules\news\assets\NewsModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\Product $model
 */

$this->title = 'Обновить продукт: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="product-update">

    <h1 style="margin-left: 25px;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'photos' => $photos
    ]) ?>

</div>
