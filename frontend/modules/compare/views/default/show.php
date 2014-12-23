<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.09.14
 * Time: 15:46
 */

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use common\modules\catalog\models\ProductTypePropertyRelation;
use common\modules\catalog\models\ProductPropertyValueRelation;
use common\modules\catalog\models\ProductPropertyValue;
use common\modules\catalog\models\ProductProperty;

$this->params['breadcrumbs'] = [
    ['label' => 'Сравнение товара', 'url' => null]
];

$this->title = "Сравнение товара - " . Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['seo_keywords']]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['seo_description']]);

?>
<div class="row no-padding-no-margin products-list" style="background-color: #fff;">
    <div class="align-center">
        <div class="row product-show">
            <?=
            \yii\widgets\Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class="col-lg-9 no-padding-no-margin">
                <h1>Сравнение товара</h1>
                <?php if (empty($products)) {
                    ?>
                    <p>Нет данных для отображения</p>
                <?php
                } else {


                    ?>
                    <table class="compare-table">
                        <tr>
                            <td></td>
                            <?php
                            foreach ($products as $product) {
                                ?>
                                <td class="text-center prod-link">
                                    <?= Html::a($product->name, ['/product/' . $product->code_number], ['target' => '_blank', 'title' => 'Просмотреть продукт']) ?>
                                </td>
                            <?php
                            }
                            ?>
                        </tr>
                        <!-- row1 -->
                        <tr class="row1">
                            <td class="col1">
<!--                                <span>Сравнить устройства из категории:</span>-->
<!--                                <ul>-->
<!--                                    <li><a href="#">Ноутбук</a></li>-->
<!--                                </ul>-->
                                <p>Вы можете сравнивать одновременно не более 3-х устройств из одной категории</p>
                            </td>
                            <?php
                            foreach ($products as $product) {
                                $photo = (empty($product->photos[0]) ? "" : $product->photos[0]->doCache('161x131', 'auto', '161x131'));
                                ?>
                                <td class="text-center">
                                    <div class="img">
                                        <?php
                                        if ($photo != "") {
                                            echo Html::img("/" . $photo, ['alt' => 'Фото - ' . $product->name]);
                                        }
                                        ?>
                                    </div>
                                    <?= Html::a('Удалить из сравнения', ['/remove-from-comparison', 'id' => $product->id], ['class' => 'remove-from-comparison']) ?>
                                </td>
                            <?php
                            }
                            ?>
                        </tr>
                        <?php
                        //foreach ($products as $product) {
                            $group = "";
                            $groupt_html = "";
                            $property = [];
                            $property_value_arr = [];
                            $i = 1;
                            $productTypeProperties = ProductTypePropertyRelation::find()->where('type_id = ' . $products[0]->product_type_id)->orderBy('property_group_id, position_number ASC')->all();

                            foreach ($productTypeProperties as $index => $type) {

                                foreach ($products as $p => $product) {
                                    $query = (new \yii\db\Query());

                                    $query->select('ppr.*, ppv.*');
                                    $query->from(ProductPropertyValueRelation::tableName() . " ppr ");

                                    $queryPropertyValue = ProductPropertyValue::find();

                                    $query->leftJoin(['ppv' => $queryPropertyValue], 'ppv.id = ppr.property_value_id');
                                    $query->where('ppv.property_id=:property_id and ppr.product_id = :product_id', [':property_id' => $type->property_id, ':product_id' => $product->id]);

                                    $property[$p] = $propertyValue = $query->one();
                                    if (!in_array($propertyValue["value"], $property_value_arr)) {
                                        $property_value_arr[] = $propertyValue["value"];
                                    }

                                    //echo "<td class='value'>".($propertyValue["value"] == null ? " --- " : $propertyValue["value"])."</td>";

                                }



                                if ($group != $type->group->frontend_name) {
                                    $i = 1;
                                    echo $groupt_html = '<tr>
                                        <td colspan="4" class="property-title">
                                            '.$type->group->frontend_name.'
                                        </td>
                                    </tr>';
                                    $group = $type->group->frontend_name;
                                }

                                if (count($property_value_arr) > 1) {
                                    ?>
                                    <tr class="properties <?=($i%2 == 0 ? 'white' : 'grey')?>">

                                        <td class="title"><?php echo ProductProperty::findOne($type->property_id)->name; ?></td>

                                        <?php
                                        foreach ($products as $p => $product) {
                                            ?>
                                            <td class='value'><?=($property[$p]["value"] == null ? " --- " : $property[$p]["value"])?></td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    $i = ($i == 1 ? 2 : 1);
                                }
                                ?>

                            <?php

                                $property_value_arr = [];
                            }
                        //}
                        ?>
                    </table>
                <?php
                }
                ?>
            </div>
            <div class="col-lg-3 no-padding-no-margin">
                <?=
                \frontend\modules\catalog\widgets\PromoProductWidget::widget([
                    'prod_of_the_day' => 1,
                    'limit' => 1
                ]);
                ?>
                <div class="clearfix">&nbsp;</div>
                <?=
                \frontend\modules\catalog\widgets\PromoProductWidget::widget([
                    'view_type' => \frontend\modules\catalog\widgets\PromoProductWidget::VIEW_BLOCK,
                    'limit' => 4
                ]);
                ?>
            </div>
        </div>
    </div>
</div>