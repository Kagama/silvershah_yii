<?php

use yii\helpers\Html;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductPromotion $model
 */

$this->title = 'Создать раздел';
$this->params['breadcrumbs'][] = ['label' => 'Продвигаемая продукция', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-promotion-create padding020">

    <h1 style="margin-left: 25px;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
