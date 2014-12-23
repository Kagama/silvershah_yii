<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.08.14
 * Time: 17:36
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

Yii::$app->view->registerJs('

function repeat_import(_url) {
    $.ajax({
        type:"get",
        url:_url,
        timeout: 50000,
        success: function(data, textStatus) {
            $("#progress-bar").append("I");
            if (data == "The End") {
                $("#content").html("<h2>Импорт завершен!</h2>");
            }
        },
        complete: function(xhr, textStatus){
            if (textStatus != "success") {
                $("#progress-bar").append("I");
                repeat_import(_url);
            }
        }
    });
}
$(function () {
    $(".ajax-upload-and-run-file").on("click", function(){
        var _url = $(this).attr("href");
        repeat_import(_url);
        return false;
    });
});
', View::POS_END, 'upload-xls');

$this->registerAssetBundle('backend\modules\post\assets\PostModuleAsset', \yii\web\View::POS_HEAD);

$this->title = 'Импорт XLS прайс-листа';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="upload-xls-index padding020 widget">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
    <p>

        <?php
        if (!$upload_result) {
        ?>
        <?= Html::label('Загрузите xls файл с товарами') ?>
        <?= Html::fileInput('upload_xls') ?>
        <i class="eicon-info" style="font-size: 12px;">
            После загрузки файла, нажмите на кнопку "Выполнить сценарий", после чего товары в базе данных будут
            обновленны.
        </i>

    <div class="form-actions">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
    </div>
<?php
} else {
    ?>
    <span class="label label-success" style="font-size: 14px; padding: 10px; line-height: 28px; text-align: left">Файл - <?= $fileName ?> загружен на сервер. <br/>Нажмите на кнопку "Выполнить сценарий" </span>
    <div id="progress-bar">
    </div>
    <div id="content">
    </div>
    <div class="form-actions">
        <?= Html::a('Выполнить сценарий', ['/catalog/upload-xls/run-xls', 'file_name' => $fileName], ['class' => 'btn btn-success ajax-upload-and-run-file']); ?>
    </div>
<?php
}
?>

    </p>



    <?php ActiveForm::end(); ?>
</div>
