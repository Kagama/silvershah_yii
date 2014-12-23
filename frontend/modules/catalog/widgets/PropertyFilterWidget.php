<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.07.14
 * Time: 3:40
 */
namespace frontend\modules\catalog\widgets;

use common\modules\catalog\models\Manufacture;
use common\modules\catalog\models\Product;
use common\modules\catalog\models\ProductProperty;
use common\modules\catalog\models\ProductPropertyValue;
use common\modules\catalog\models\ProductPropertyValueRelation;
use common\modules\catalog\models\ProductTypePropertyRelation;
use yii\base\Widget;
use yii\db\Query;

class PropertyFilterWidget extends Widget
{
    public $product_type = null;
    public $category = null;

    public function run()
    {
        if ($this->product_type == null || $this->category == null)
            return;


        $propertyArr = [];
        /**
         * Получаем свойства продукта связанные с типом продукта
         *
         * SELECT type_prop_rel.*, prop.alt_name as property_name
         * FROM t_kg_product_type_property_relation type_prop_rel, t_kg_product_property prop
         * WHERE type_prop_rel.type_id = 1 and type_prop_rel.property_id = prop.id and prop.is_visible_to_filter = 1
         * Order by type_prop_rel.position_number ASC
         */
        $query = new Query();
        $query->select('type_prop_rel.*, prop.alt_name as property_name, prop.name');
        $query->from(ProductTypePropertyRelation::tableName() . " type_prop_rel, " . ProductProperty::tableName() . " prop ");
        $query->where('type_prop_rel.type_id = :type_id and type_prop_rel.property_id = prop.id and prop.is_visible_to_filter = 1', [
            ':type_id' => $this->product_type
        ]);
        $query->orderBy('type_prop_rel.position_number ASC');
        $propertyArr = $query->all();

        /**
         * Получаем заначения свойстваы
         */
        foreach ($propertyArr as $index => $property) {
            $query = new Query();
            $query->select("prop_value.id, prop_value.value");
            $query->from(ProductPropertyValue::tableName()." prop_value ");
            $query->where('prop_value.property_id = :id', [':id' => $property['property_id']]);
            $query->orderBy('prop_value.value ASC');
            $propertyArr[$index]['property_values'] = $query->all();
            unset($query);
        }

        /**
         * Получаем максимальную и минимальную стоимость продукта
         */
        $query = new Query();
        $query->select(' MAX(prod.price) as max_price, MIN(price) as min_price');
        $query->from(Product::tableName() . " prod ");
        $query->where('prod.product_type_id = :type_id and prod.category_id = :cat_id and prod.visible = 1', [
            ':type_id' => $this->product_type,
            ':cat_id' => $this->category->id
        ]);
        $price_range = $query->one();

        /**
         * Получаем производеля
         */
        $query = new Query();

        $query->select(' fabric.name as name, fabric.id as id ', 'DISTINCT');
        $query->from(Product::tableName() . " prod , ".Manufacture::tableName()." fabric ");
        $query->where('prod.product_type_id = :type_id and prod.category_id = :cat_id and prod.visible = 1 and prod.manufacture_id = fabric.id', [
            ':type_id' => $this->product_type,
            ':cat_id' => $this->category->id
        ]);
        $fabric_range = $query->all();

        return $this->render('_property_filter_widget', [
            'properties' => $propertyArr,
            'category' => $this->category,
            'price_range' => $price_range,
            'fabric_range' => $fabric_range
        ]);
    }
}