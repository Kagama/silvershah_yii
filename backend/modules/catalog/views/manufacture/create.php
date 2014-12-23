<?php

use yii\helpers\Html;

$this->registerAssetBundle('backend\assets\FileUploadAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\Manufacture $model
 */

$this->title = 'Создать производителя';
$this->params['breadcrumbs'][] = ['label' => 'Производитель', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacture-create padding020">

    <h1 style="margin-left: 25px;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
