<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.07.14
 * Time: 18:06
 */
use yii\helpers\Html;
use common\modules\catalog\models\ProductTypePropertyRelation;
use common\modules\catalog\models\ProductPropertyValueRelation;
use common\modules\catalog\models\ProductPropertyValue;
use common\modules\catalog\models\ProductProperty;
?>
<table>
<?php
$group = "";
$productTypeProperties = ProductTypePropertyRelation::find()->where('type_id = '.$model->product_type_id)->orderBy('property_group_id, position_number ASC')->all();
foreach ($productTypeProperties as $index => $type) {
    $query = (new \yii\db\Query());

    $query->select('ppr.*, ppv.*');
    $query->from(ProductPropertyValueRelation::tableName()." ppr ");

    $queryPropertyValue = ProductPropertyValue::find();

    $query->leftJoin(['ppv' => $queryPropertyValue], 'ppv.id = ppr.property_value_id');
    $query->where('ppv.property_id=:property_id and ppr.product_id = :product_id', [':property_id' => $type->property_id, ':product_id' => $model->id]);

    $propertyValue = $query->one();

    $index = $index + 1;
    ?>
    <?php
    if ($group != $type->group->frontend_name) {
        ?>
<!--        --><?//=$type->group->frontend_name?>
        <?php
        $group = $type->group->frontend_name;
    }
    ?>
    <tr>
    <?php
    if ($propertyValue["value"] != "") {
        ?>
        <td><?php echo ProductProperty::findOne($type->property_id)->name; ?></td>
        <td><?php echo $propertyValue["value"] ?></td>
        <?php
    }
    ?>
    </tr>
<?php
}
?>
</table>

<?php
//echo \frontend\modules\catalog\widgets\RenderPromotionProductWidget::widget([
//    'view_type' => \frontend\modules\catalog\widgets\RenderPromotionProductWidget::VIEW_HORIZIONTAL,
//    'models' => $model->crossSellProducts,
//    'title' => 'С этим продуктом часто покупают'
//]);
//?>