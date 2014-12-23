<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\catalog\models\ProductPropertyGroup;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductProperty $model
 * @var yii\widgets\ActiveForm $form
 */
$group_id = Yii::$app->request->get('group_id');
if (!empty($group_id) ) {
    $model->group_id = (int) $group_id;
}
?>
<section class="widget">
    <div class="product-property-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(ProductPropertyGroup::find()->all(), "id", "frontend_name"), ['prompt' => '---']) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 254]) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => 254]) ?>

        <?= $form->field($model, 'alt_name')->textInput(['maxlength' => 254]) ?>

        <?= $form->field($model, 'is_visible_to_filter')->checkbox(); ?>

<!--        <div style="position: relative;" class="icheckbox_square-grey checked"><input style="position: absolute; opacity: 0;" id="change-password" name="change-password" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>-->
<!--        Request password change-->
<!--        </label>-->

        <div class="form-actions">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::submitButton('Сохранить и создать новый', ['class' => 'btn btn-success', 'name' => 'save_and_add_new', 'value' => 'save']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</section>
