<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

Yii::$app->view->registerJs('
    $("fieldset legend").on("click", function (){
        $("fieldset legend .table").each(function(){
            $(this).hide();
        });
        $(this).next(".table").show();
    });

', View::POS_END, 'product-type');

/**
 * @var yii\web\View $this
 * @var common\modules\catalog\models\ProductType $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php $form = ActiveForm::begin([
]); ?>
<div class="content container">
    <div class="row">
        <div class="col-md-7">
            <section class="widget">
                <div class="body">
                    <div class="product-type-form">


                        <?= $form->field($model, 'name')->textInput(['maxlength' => 254]) ?>

                        <div class="form-actions">
                            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>


                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-5">
            <div class="body">
                <section class="widget">
                    <h4><i class="fa fa-cogs"></i> Свойтства продукта</h4>
                    <?

                    $addInCondition = array();
                    $positionArr = array();
                    $isVisibleToFilterArr = array();

                    if (!empty($model->properties)) {
                        foreach ($model->properties as $property) {
                            $addInCondition[] = $property->id;
                            $relModel = \common\modules\catalog\models\ProductTypePropertyRelation::find()->where(['type_id' => $model->id, 'property_id' => $property->id])->one();
                            $positionArr[$property->id] = $relModel->position_number;
                        }
                    }


                    $propertyGroup = \common\modules\catalog\models\ProductPropertyGroup::find()->orderBy('frontend_name ASC')->all();

                    echo Html::beginTag('table', ['class' => 'table']);
                    echo Html::beginTag('tr');
                    echo Html::beginTag('th', ['style' => 'width:20%;']);
                    echo "Позиция";
                    echo Html::endTag('th');
                    echo Html::beginTag('th', ['style' => 'width:20%;']);
                    echo "Выбрать";
                    echo Html::endTag('th');
                    echo Html::beginTag('th');
                    echo "Название свойства";
                    echo Html::endTag('th');
                    echo Html::endTag('tr');
                    echo Html::endTag('table');
                    ?>
                    <div style="height: 530px; overflow: auto; position: relative;" class="property-group">
                        <?

                        foreach ($propertyGroup as $group) {
                            echo Html::beginTag('fieldset');
                            echo Html::tag('legend', $group->frontend_name);
                            if (!empty($group->properties)) {
                                echo Html::beginTag('table', ['class' => 'table']);
                                foreach ($group->properties as $property) {

                                    echo Html::beginTag('tr');
                                    echo Html::beginTag('td', array('style' => 'text-align:center; width:20%;'));
                                    echo Html::textInput('ProductTypePropertyRelation[' . $property->id . '][position_number]', (!isset($positionArr[$property->id]) || $positionArr[$property->id] == null  ? 0 : $positionArr[$property->id]), ['maxlength' => 2, 'style' => 'width:40px;']);
                                    echo Html::hiddenInput('ProductTypePropertyRelation[' . $property->id . '][property_group_id]', ($property->group_id == null ? null : $property->group_id));
                                    echo Html::endTag('td');
                                    echo Html::beginTag('td', array('style' => 'text-align:center; width:20%;', 'class' => 'propertyCheckBox'));
                                    echo Html::checkbox('ProductProperty[' . $property->id . ']', in_array($property->id, $addInCondition), array('id' => 'ProductProperty_' . $property->id, 'value' => $property->id));
                                    echo Html::endTag('td');
                                    echo Html::beginTag('td', array('style' => 'text-align:left; padding-left:20px;'));
                                    echo Html::label($property->name, 'ProductProperty_' . $property->id, array('style' => 'cursor:pointer;'));
                                    echo Html::endTag('td');
                                    echo Html::endTag('tr');

                                }
                                echo Html::endTag('table');
                            }
                            echo Html::endTag('fieldset');

                        }


                        ?>
                    </div>
                    <?
                    //        echo CHtml::checkBoxList('ProductProperty', $addInCondition, CHtml::listData($properties, 'id', 'name'), array('checkAll' => 'Check all'));
                    ?>
                    <fieldset>
                        <legend></legend>
                    </fieldset>
                </section>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
