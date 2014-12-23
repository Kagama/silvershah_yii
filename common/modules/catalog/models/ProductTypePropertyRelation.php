<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "t_kg_product_type_property_relation".
 *
 * @property integer $property_id
 * @property integer $type_id
 * @property integer $position_number
 * @property integer $property_group_id
 */
class ProductTypePropertyRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_type_property_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'type_id', 'property_group_id'], 'required'],
            [['property_id', 'type_id', 'position_number', 'property_group_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'property_id' => 'Свойство ',
            'type_id' => 'Тип продукта',
            'position_number' => 'Позиция отобразения свойства',
            'property_group_id' => 'Группа свойств'
        ];
    }

    public function getProperty()
    {
        return $this->hasOne(ProductProperty::className(), ['id' => 'property_id']);
    }

    public function getGroup()
    {
        return $this->hasOne(ProductPropertyGroup::className(), ['id' =>'property_group_id']);
    }
}
