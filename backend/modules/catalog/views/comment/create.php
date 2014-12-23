<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductComment $model
 */

$this->title = 'Create Product Comment';
$this->params['breadcrumbs'][] = ['label' => 'Product Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
