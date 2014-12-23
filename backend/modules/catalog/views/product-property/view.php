<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductProperty $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Свойство продукта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-property-view padding020">

    <h1><?= Html::encode($this->title) ?></h1>
    <section class="widget">
        <p>
            <?= Html::a('Создать свойство продукта', ['create'], ['class' => 'btn btn-success']) ?>
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
                'name',
                'alt_name',
                'title',
                [
                    'attribute' => 'group_id',
                    'value' => $model->group->frontend_name
                ],
                [
                    'attribute' => 'is_visible_to_filter',
                    'value' => ($model->is_visible_to_filter == 1 ? "Отобразить" : "Не отображать"),
                ],
            ],
        ]) ?>
    </section>
</div>
