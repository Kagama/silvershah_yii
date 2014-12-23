<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductType $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Тип продукта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-view padding020">

    <h1><?= Html::encode($this->title) ?></h1>
    <section class="widget">
        <p>
            <?= Html::a('Создать тип продукта', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Список', ['index'], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Удаить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы действительно хотите удалить запись?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
            ],
        ]) ?>
    </section>
</div>
