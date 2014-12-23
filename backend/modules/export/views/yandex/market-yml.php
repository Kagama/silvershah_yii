<?php
/**
 * Created by PhpStorm.
 * User: pashaevs
 * Date: 02.10.14
 * Time: 13:21
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

$this->title = 'Yandex market YML экспорт';
$this->params['breadcrumbs'][] = ['label' => 'Экспорт', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="export-create padding020 widget">
    <?php $form = ActiveForm::begin([
        'options' => [
            'novalidate' => "novalidate",
            'method' => "post",
            'data-validate' => "parsley"
        ]
    ]); ?>
    <?=Html::submitButton('Создать экспортный файл', ['class' => 'btn btn-danger', 'value' => 'do-yandex-export-yml', 'name' => 'yandex-export'])?>
    <?php ActiveForm::end(); ?>
</div>