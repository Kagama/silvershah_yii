<?php

use yii\helpers\Html;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductProperty $model
 */

$this->title = 'Создать свойство товара';
$this->params['breadcrumbs'][] = ['label' => 'Свойство товара', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-property-create padding020">

    <h1><?= Html::encode($this->title) ?></h1>
        <?=
        $this->render('_form', [
            'model' => $model,
        ]) ?>

</div>
