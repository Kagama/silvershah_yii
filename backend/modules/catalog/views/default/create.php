<?php

use yii\helpers\Html;
$this->registerAssetBundle('backend\assets\FileUploadAsset', \yii\web\View::POS_HEAD);
//$this->registerAssetBundle('backend\modules\news\assets\NewsModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\Product $model
 */

$this->title = 'Создать продукт';
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1 style="margin-left: 25px;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'photos' => $photos
    ]) ?>

</div>
