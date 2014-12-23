<?php
use \yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.05.14
 * Time: 19:16
 */
?>
<div class="properties">
    <? if (!empty($productTypePropertyRelation)) { ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width: 200px;">Название</th>
            <th>Значение</th>
            <th></th>
            <th>Добавить новое значение</th>
        </tr>
        </thead>
        <tbody>
        <?
        $group = "";
        foreach ($productTypePropertyRelation as $property) {
//            var_dump($property->getProperty()->toArray());
        ?>
            <?php
            if ($group != $property->group->frontend_name) {
                ?>
                <tr>
                    <td colspan="4" style="font-size: 24px;  border-bottom: 1px solid #fff;"><?=$property->group->frontend_name?></td>
                </tr>
                <?php
                $group = $property->group->frontend_name;
            }
            ?>
            <tr>
                <td><?= $property->property->name; ?></td>
                <td >
                    <?
                    $property_values = \common\modules\catalog\models\ProductPropertyValue::find()->
                        where(['property_id' => $property->property->id])->all();

//                    $property_value = ProductPropertyValue::model()->findAllByAttributes(array('property_id' => $rel->property_id));
                    $property_id = null;

                    foreach($property_values as $pv) {
                        $rel = null;
                        if (!empty($product_id)) {
                            $rel = \common\modules\catalog\models\ProductPropertyValueRelation::find()->
                                where(['product_id' => $product_id, 'property_value_id' => $pv->id])->one();

                            if ($rel != null) {
                                $property_id = $rel->property_value_id;
                                break;
                            }
                        }

                    }
//                    echo $property_id;
                    echo Html::dropDownList('PropertyValue['.$property->property->id.'][id]',
                        $property_id,
                        \yii\helpers\ArrayHelper::map($property_values, 'id', 'value'),
                        ['prompt' => '---', 'style' => 'width:240px;']);
                    ?>

                </td>
                <td style="text-align: center;"><i class='fa fa-arrow-left'></i></td>
                <td>
                    <?= Html::input('text', 'PropertyValue['.$property->property->id.'][name]', ""); ?>
                </td>
            </tr>
        <?
        }
        ?>
        </tbody>
    </table>
    <? } else { ?>
        <span>Пусто</span>
    <? } ?>
</div>