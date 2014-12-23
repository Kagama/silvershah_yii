<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->registerAssetBundle('backend\assets\FileUploadAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\Product $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view padding020">
    <section class="widget">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Список', ['index'], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Удалить', ['delete', 'id' => $model->id], [
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
                'code_number',
                'model',
                'manufacture_id',
                'name',
                'alt_name',
                'h1_name',
                'description:ntext',
                'old_price',
                'price',
                'quantity',
                'product_type_id',
                'visible',
                'seo_title',
                'seo_keywords',
                'seo_description',
                'rate',
                'rate_count',
                'pre_order',
            ],
        ]) ?>
    </section>
</div>
