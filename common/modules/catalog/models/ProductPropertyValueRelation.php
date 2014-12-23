<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "t_kg_product_property_relation".
 *
 * @property integer $product_id
 * @property integer $property_value_id
 */
class ProductPropertyValueRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_property_value_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'property_value_id'], 'required'],
            [['product_id', 'property_value_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'property_value_id' => 'Property ID',
        ];
    }

    public function createRelation($product_id) {
        if (isset($_POST['PropertyValue'])) {
//            if (!empty($_POST['PropertyValue'])) {
            $this->deleteAll('product_id = :product_id', [':product_id' => (int) $product_id]);
//            }

            foreach($_POST['PropertyValue'] as $index =>  $value) {
                $property_id = intval($index);
                $property_value = trim($value['name']);
                $prop_value = new ProductPropertyValue;
                if (!empty($value['name'])) {
                    $prop_value->property_id = $property_id;
                    $prop_value->value = $property_value;
                    $prop_value->save();
                }
                $this->setIsNewRecord(true);
                $this->product_id = $product_id;
                $this->property_value_id = (!empty($value['name']) ? $prop_value->getPrimaryKey() : intval($value['id']) );
                $this->save();
                unset($prop_value);
            }
        }

    }


}
