<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\Manufacture $model
 * @var yii\widgets\ActiveForm $form
 */


?>
<section class="widget">
    <div class="manufacture-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'id' => 'fileupload',
                'enctype' => 'multipart/form-data'
            ]
        ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 254]) ?>

        <!--        --><? //= $form->field($model, 'alt_name')->textInput(['maxlength' => 254]) ?>

        <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
        <?
        if (!empty($model->src)) {
            echo Html::tag('div',
                Html::tag('div',
                    Html::img($model->doCache('200x200')) . Html::a(Html::tag('i', '', ['class' => 'fa fa-times-circle-o']) . " " . 'Удалить', ['/catalog/manufacture/remove-img', 'id' => $model->id],
                        [
                            'class' => 'btn btn-danger',
//                            'data' => [
//                                'confirm' => 'Вы действительно хотите удалить фото?',
//                                'method' => 'get',
//                            ]
                        ]), ['class' => 'photo-item']
                ), ['class' => 'show-img']
            );
        }
        ?>
        <?=
        $form->field($model, 'img', [
            'template' => '<div class="form-actions fileupload-buttonbar no-margin">
                                <span class="btn btn-sm btn-default fileinput-button">
                                        <i class="fa fa-plus"></i>
                                        <span>{label}</span>
                                        {input}
                                    </span>
                                    <div class="help-block">{error}</div>
                            </div>
                            <div class="fileupload-loading"><i class="fa fa-spin fa-spinner"></i></div>
                            <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>'
        ])->fileInput(); ?>

        <!--    --><? //= $form->field($model, 'src')->textInput(['maxlength' => 512]) ?>

        <fieldset>
            <legend>SEO Атрибуты</legend>
            <?= $form->field($model, 'seo_title')->textInput(['maxlength' => 512]) ?>

            <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => 512]) ?>

            <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>
        </fieldset>


        <div class="form-actions">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</section>
<script id="template-upload" type="text/template">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
        <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
        <td>
            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0"
                 aria-valuemax="100" aria-valuenow="0">
                <div class="bar" style="width:0%;"></div>
            </div>
        </td>
        <td>{% if (!o.options.autoUpload) { %}
            <button class="btn btn-primary btn-sm start">
                <i class="fa fa-upload"></i>
                <span>Start</span>
            </button>
            {% } %}
        </td>
        {% } else { %}
        <td colspan="2"></td>
        {% } %}
        <td>{% if (!i) { %}
            <button class="btn btn-warning btn-sm cancel">
                <i class="fa fa-ban"></i>
                <span>Cancel</span>
            </button>
            {% } %}
        </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/template">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
        <td></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
        <td class="preview">{% if (file.thumbnail_url) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img
                src="{%=file.thumbnail_url%}"></a>
            {% } %}
        </td>
        <td class="name">
            <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}"
               download="{%=file.name%}">{%=file.name%}</a>
        </td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        <td colspan="2"></td>
        {% } %}
        <td>
            <button class="btn btn-danger btn-sm delete" data-type="{%=file.delete_type%}"
                    data-url="{%=file.delete_url%}"
            {% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
            <i class="fa fa-trash"></i>
            <span>Delete</span>
            </button>
        </td>
    </tr>
    {% } %}
</script>