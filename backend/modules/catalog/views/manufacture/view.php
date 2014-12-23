<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->registerAssetBundle('backend\assets\FileUploadAsset', \yii\web\View::POS_HEAD);
/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\Manufacture $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Производитель', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacture-view padding020">
    <section class="widget">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Создать производителя', ['create'], ['class' => 'btn btn-success']) ?>
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
                'text:ntext',
                [
                    'attribute' => 'img',
                    'value' => Html::img($model->doCache('200x200')),
                    'format' => 'html'
                ],
//            'img:image',
//            'src',
                'seo_title',
                'seo_keywords',
                'seo_description:ntext',
            ],
        ]) ?>
    </section>
</div>
