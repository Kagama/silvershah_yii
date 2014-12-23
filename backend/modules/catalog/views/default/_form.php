<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\Product $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'fileupload',
        'enctype' => 'multipart/form-data'
    ]
]); ?>
<div class="product-form">
<div class="content container">
<?= $form->errorSummary([$model, $photos], ['class' => 'alert alert-danger']); ?>
<div class="row">
<div class="col-md-8">
<section class="widget widget-tabs">
<div class="body">

<header>
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#main" data-toggle="tab">Описание</a>
        </li>
        <li>
            <a href="#priсe" data-toggle="tab">Цена</a>
        </li>
        <li>
            <a href="#photos" data-toggle="tab">Фото</a>
        </li>
        <li>
            <a href="#properties" data-toggle="tab">Тип и Свойства</a>
        </li>
        <li>
            <a href="#present" data-toggle="tab">Подарок</a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Связанные товары <i
                    class="fa fa-caret-down"></i></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#related_products" data-toggle="tab">Похожие товары</a>
                </li>
                <li>
                    <a href="#up-sell" data-toggle="tab">Up-Sell</a>
                </li>
                <li>
                    <a href="#cross-sell" data-toggle="tab">Cross-Sell</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#export" data-toggle="tab">Экспорт</a>
        </li>
    </ul>
</header>
<div class="body tab-content">
<div id="main" class="tab-pane active">
    <div class="row-fluid clearfix">
        <div class="col-md-3">
            <?= $form->field($model, 'code_number')->textInput(['maxlength' => 254]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'manufacture_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\modules\catalog\models\Manufacture::find()->all(), 'id', 'name'), ['prompt' => '- пусто -']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'model')->textInput(['maxlength' => 254]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'quantity')->textInput() ?>
        </div>
    </div>
    <div class="row-fluid clearfix">
        <div class="col-md-6">
            <?= $form->field($model, 'visible')->checkbox() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'warranty')->textInput() ?>
        </div>
    </div>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 254]) ?>

    <?= $form->field($model, 'h1_name')->textInput(['maxlength' => 254]) ?>

    <?=
    $form->field($model, 'description', [
    'template' => '
                {label}
                <div class="textarea-content">{input}</div>
                {error}
            '
        ])->widget(sim2github\imperavi\widgets\Redactor::className(), [
        'options' => [
            'debug' => 'true',
        ],
        'clientOptions' => [ // [More about settings](http://imperavi.com/redactor/docs/settings/)
            'convertImageLinks' => 'true', //By default
            'convertVideoLinks' => 'true', //By default
            //'wym' => 'true',
            //'air' => 'true',
            'linkEmail' => 'true', //By default
            'lang' => 'ru',
            'imageGetJson' => \Yii::getAlias('@web') . '/redactor/upload/imagejson', //By default
            'plugins' => [ // [More about plugins](http://imperavi.com/redactor/plugins/)
                'ace',
                'clips',
                'fullscreen']
        ],
    ]) ?>

    <?=
    $form->field($model, 'overview', [
    'template' => '
                {label}
                <div class="textarea-content">{input}</div>
                {error}
            '
        ])->widget(sim2github\imperavi\widgets\Redactor::className(), [
        'options' => [
            'debug' => 'true',
        ],
        'clientOptions' => [ // [More about settings](http://imperavi.com/redactor/docs/settings/)
            'convertImageLinks' => 'true', //By default
            'convertVideoLinks' => 'true', //By default
            //'wym' => 'true',
            //'air' => 'true',
            'linkEmail' => 'true', //By default
            'lang' => 'ru',
            'imageGetJson' => \Yii::getAlias('@web') . '/redactor/upload/imagejson', //By default
            'plugins' => [ // [More about plugins](http://imperavi.com/redactor/plugins/)
                'ace',
                'clips',
                'fullscreen']
        ],
    ]) ?>


    <fieldset>
        <legend>SEO Атрибутика</legend>
        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => 254]) ?>
        <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => 254]) ?>
        <?= $form->field($model, 'seo_description')->textarea(['style' => 'height:100px;']) ?>
    </fieldset>
</div>
<div id="priсe" class="tab-pane">
    <?= $form->field($model, 'pre_order')->checkbox() ?>
    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'old_price')->textInput() ?>
    <?= $form->field($model, 'discount')->textInput() ?>
</div>
<div id="photos" class="tab-pane">
    <?
    if (!empty($model->photos)) {
        echo '<ul class="photos-list">';
        foreach ($model->photos as $photo) {
            echo "<li>
                    <p>" . Html::a("<span class='glyphicon glyphicon-trash'></span>", ['/catalog/photo/delete', 'id' => $photo->id], ['class' => 'deletePhoto']) . "&nbsp;&nbsp;&nbsp;
                       " . Html::a("<span class='glyphicon glyphicon-repeat'></span>", ['/catalog/photo/ajax-rotate', 'id' => $photo->id], ['class' => 'rotatePhoto']) . "&nbsp;&nbsp;&nbsp;
                       " . Html::a("<span class='glyphicon " . ($photo->is_main == 0 ? "glyphicon-unchecked" : "glyphicon-check") . "'></span>", ['/catalog/photo/ajax-change-main-status', 'id' => $photo->id], ['class' => 'ajaxChangeMainStatus']) . "&nbsp;&nbsp;&nbsp;
                    </p>" . Html::img("/".$photo->doCache('200x200', 'auto')) . "
               </li>";
        }
        echo '</ul>';
    }
    ?>
    <?=
    $form->field(new \common\modules\catalog\models\ProductPhoto(), 'name[]', [

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
    ])->fileInput(['multiple' => true]); ?>
</div>

<div id="properties" class="tab-pane">
    <?= $form->field($model, 'product_type_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\modules\catalog\models\ProductType::find()->all(), 'id', 'name'), ['prompt' => '- пусто -', 'onchange' => 'js:loadProductProperties(this);']) ?>
    <fieldset>
        <legend>Свойства продукта</legend>
        <?=
        \backend\modules\catalog\widgets\PropertyRenderWidget::widget([
            'type_id' => $model->product_type_id,
            'product_id' => $model->getPrimaryKey()
        ]) ?>
    </fieldset>
</div>

<div id="present" class="tab-pane">


</div>
<!-- related_products  -->
<div id="related_products" class="tab-pane">
    <?php
    $prodArray = \common\modules\catalog\models\Product::find()->orderBy('code_number ASC')->all();
    $sourceArr = [];
    foreach ($prodArray as $prod) {
        $sourceArr[] = [
            "value" => (string) $prod->h1_name,
            'label' => (string) $prod->code_number,
            'id' => $prod->id,
            'photo' => ((empty($prod->photos[0]) ? "" : $prod->photos[0]->doCache('100x100'))),

        ];
    }
    ?>
    <label>Выберите товар по Акртиклу для связки с текущим продуктом.</label><br/>
    <?=
    \yii\jui\AutoComplete::widget([
        'name' => 'product_code_number',
        'id' => 'product_code_number',
        'clientOptions' => [
            'source' => $sourceArr,
            'autoFill' => true,
            'minLength' => '2',
            'select' => new JsExpression("function(event, ui){
                    addProductToRelationBlock('related_products_block', ui.item, 'ProductsRelatedProduct');
                }"),
        ],
    ]);
    ?>
    <section class="widget" style="margin-top: 10px;">
        <div class="row relatedblock-css related_products_block">
            <?php
            if (!empty($model->relProducts)) {
                foreach ($model->relProducts as $index => $prod) {
                    ?>
                    <div class='col-lg-3'>
                        <input type='hidden' name='ProductsRelatedProduct[<?= $index ?>][related_product_id]'
                               value='<?= $prod->related_product_id; ?>'/>
                        <input class='promo_position' type='text' name='ProductsRelatedProduct[<?= $index ?>][position]'
                               value='<?= $prod->position; ?>' style='width:40px;'/>
                        <a href='#' class='delete-rel-prod' onclick='deleteRelProd(this); return false;'><span
                                class='glyphicon glyphicon-trash'></span></a>

                        <p>
                            <strong><?= $prod->product->code_number ?></strong> : <?= $prod->product->h1_name ?>
                        </p>
                        <img
                            src='/<?= (empty($prod->product->photos[0]) ? "" : $prod->product->photos[0]->doCache('100x100')) ?>'
                            alt='<?= $prod->product->name ?>'/>
                    </div>
                <?php
                }
            }
            ?>

        </div>
    </section>
</div>
<!-- end related_products  -->
<!-- up-sell  -->
<div id="up-sell" class="tab-pane">
    <label>Выберите товар по Акртиклу для связки с текущим продуктом.</label><br/>
    <?=
    \yii\jui\AutoComplete::widget([
        'name' => 'product_code_number',
        'id' => 'product_code_number2',
        'clientOptions' => [
            'source' => $sourceArr,
            'autoFill' => true,
            'minLength' => '2',
            'select' => new JsExpression("function(event, ui){
                    addProductToRelationBlock('up_sell_block', ui.item, 'ProductUpSell');
                }"),
        ],
    ]);
    ?>
    <section class="widget" style="margin-top: 10px;">
        <!--            <div class="body" >-->
        <div class="row relatedblock-css up_sell_block">
            <?php
            if (!empty($model->upSell)) {
                foreach ($model->upSell as $index => $prod) {
                    ?>
                    <div class='col-lg-3'>
                        <input type='hidden' name='ProductUpSell[<?= $index ?>][related_product_id]'
                               value='<?= $prod->related_product_id; ?>'/>
                        <input class='promo_position' type='text' name='ProductUpSell[<?= $index ?>][position]'
                               value='<?= $prod->position; ?>' style='width:40px;'/>
                        <a href='#' class='delete-rel-prod' onclick='deleteRelProd(this); return false;'><span
                                class='glyphicon glyphicon-trash'></span></a>

                        <p>
                            <strong><?= $prod->product->code_number ?></strong> : <?= $prod->product->h1_name ?>
                        </p>
                        <img
                            src='/<?= (empty($prod->product->photos[0]) ? "" : $prod->product->photos[0]->doCache('100x100')) ?>'
                            alt='<?= $prod->product->name ?>'/>
                    </div>
                <?php
                }
            }
            ?>

        </div>
        <!--            </div>-->
    </section>
</div>
<!-- end up-sell  -->
<!--  cross-sell  -->
<div id="cross-sell" class="tab-pane">
    <label>Выберите товар по Акртиклу для связки с текущим продуктом.</label><br/>
    <?=
    \yii\jui\AutoComplete::widget([
        'name' => 'product_code_number',
        'id' => 'product_code_number3',
        'clientOptions' => [
            'source' => $sourceArr,
            'autoFill' => true,
            'minLength' => '2',
            'select' => new JsExpression("function(event, ui){
                    addProductToRelationBlock('cross_sell_block', ui.item, 'ProductCrossSell');
                }"),
        ],
    ]);
    ?>
    <section class="widget" style="margin-top: 10px;">
        <div class="row relatedblock-css cross_sell_block">
            <?php
            if (!empty($model->crossSell)) {
                foreach ($model->crossSell as $index => $prod) {
                    ?>
                    <div class='col-lg-3'>
                        <input type='hidden' name='ProductCrossSell[<?= $index ?>][related_product_id]'
                               value='<?= $prod->related_product_id; ?>'/>
                        <input class='promo_position' type='text' name='ProductCrossSell[<?= $index ?>][position]'
                               value='<?= $prod->position; ?>' style='width:40px;'/>
                        <a href='#' class='delete-rel-prod' onclick='deleteRelProd(this); return false;'><span
                                class='glyphicon glyphicon-trash'></span></a>

                        <p>
                            <strong><?= $prod->product->code_number ?></strong> : <?= $prod->product->h1_name ?>
                        </p>
                        <img
                            src='/<?= (empty($prod->product->photos[0]) ? "" : $prod->product->photos[0]->doCache('100x100')) ?>'
                            alt='<?= $prod->product->name ?>'/>
                    </div>
                <?php
                }
            }
            ?>
        </div>
    </section>
</div>
<!--  end cross-sell  -->
<div id="export" class="tab-pane">
    <?= $form->field($model, 'yandex_export')->checkbox() ?>
</div>
</div>
<div class="form-actions">
    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
    if ($model->isNewRecord) {
        echo Html::submitButton('Создать и продолжить', ['class' => 'btn btn-success', 'value' => 'save-and-continue', 'name' => 'submit']);
    }
    ?>
</div>

</div>
</section>
</div>
<div class="col-md-4">
    <section class="widget">
        <div class="body">
            <h4><i class="fa fa-cogs"></i> Категория</h4>
            <?
            $category = new \common\modules\catalog\models\ProductCategory();
            echo $category->getUl($model, true);
            ?>
        </div>
    </section>
</div>
</div>
</div>
</div>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
    function addProductToRelationBlock($class, $item, $input_name) {
        var length = $("." + $class + ' div').length;
        $("." + $class).append("<div class='col-lg-3'>" +
            "<input type='hidden' name='" + $input_name + "[" + length + "][related_product_id]' value='" + $item.id + "' />" +
            "<input class='promo_position' type='text' name='" + $input_name + "[" + length + "][position]' value='999' style='width:40px;' />" +
            "<a href='#' class='delete-rel-prod' onclick='deleteRelProd(this); return false;'><span class='glyphicon glyphicon-trash'></span></a>" +
            "<p>" +
            "<strong>" + $item.value + "</strong> : " + $item.label + "" +
            "</p>" +
            "<img src='/" + $item.photo + "' alt='" + $item.label + "' />" +
            "</div>");
//        $index_of_lement = $index_of_lement + 1;
    }
    function deleteRelProd(_this) {
        $(_this).parent('div').remove();
        return false;
    }
</script>
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
            <!--<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0"-->
                 <!--aria-valuemax="100" aria-valuenow="0">-->
                <!--<div class="bar" style="width:0%;"></div>-->
            <!--</div>-->
        </td>
        <td>{% if (!o.options.autoUpload) { %}
            <!--<button class="btn btn-primary btn-sm start">-->
            <!--<i class="fa fa-upload"></i>-->
            <!--<span>Start</span>-->
            <!--</button>-->
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

<script type="text/javascript">

    $(document).ready(function () {

//        setTimeout(checkFormError());

        $('.ajaxChangeMainStatus').on('click', function () {
            var _url = $(this).attr('href');
            var element = $(this);
            $.ajax({
                type: 'post',
                url: _url,
                dataType: 'json',
                success: function (json) {
//                    "glyphicon-unchecked" : "glyphicon-check"
                    if (json.error) {
                        alert(json.message);
                    } else {
                        $('.photos-list li p a.ajaxChangeMainStatus').each(function (i) {
                            $(this).children('span').removeClass('glyphicon-check');
                            $(this).children('span').addClass('glyphicon-unchecked');
                        });
                        element.children('span').removeClass('glyphicon-unchecked');
                        element.children('span').addClass('glyphicon-check');
                    }

                }
            });
            return false;
        });

        $('.deletePhoto').on('click', function () {
            if (confirm('Вы действительно хотите удалить фото?')) {
                var _Url = $(this).attr('href');
                var _li = $(this).parent('p').parent('li');

                $.ajax({
                    type: 'POST',
                    url: _Url,
                    dataType: 'json',
                    success: function (msg) {
                        if (msg.error) {
                            alert(msg.message);
                        } else {
                            _li.hide('slow');
                        }
                    }
                });
            }
            return false;
        });

        $('.rotatePhoto').on('click', function () {
            var _url = $(this).attr('href');
            var _img = $(this).parent('p').parent('li').children('img');

            $.ajax({
                type: 'POST',
                url: _url,
                dataType: 'json',
                success: function (msg) {
                    if (msg.error) {
                        alert(msg.message);
                    } else {
                        $(_img).attr('src', $(_img).attr('src') + '?' + Math.random());
                    }
                }
            });
            return false;
        });
    });

    function loadProductProperties(_this) {
        var prodTypeValue = $(_this).val();
        if (prodTypeValue != "") {
            $.ajax({
                type: 'post',
                url: "<?= \yii\helpers\Url::toRoute('/catalog/product-property/get-properties-by-type') ?>",
                data: 'type_id=' + prodTypeValue + "&product_id=<?= $model->getPrimaryKey();?>",
                dataType: 'json',
                success: function (json) {
                    if (json.error == false) {
                        $('.properties').replaceWith(json.html);
                    } else {

                        alert(json.message);
                    }
                }
            });
        }
    }
</script>