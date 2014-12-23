<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductProperty $model
 */

$this->title = $model->backend_name;
$this->params['breadcrumbs'][] = ['label' => 'Группа свойств', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-property-view padding020">

    <h1><?= Html::encode($this->title) ?></h1>
    <section class="widget">
        <p>
            <?= Html::a('Создать группу', ['create'], ['class' => 'btn btn-success']) ?>
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
                'backend_name',
                'frontend_name',
            ],
        ]) ?>
    </section>
</div>
