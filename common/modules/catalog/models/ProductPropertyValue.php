<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "t_kg_product_property_value".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $value
 */
class ProductPropertyValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_property_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'value'], 'required'],
            [['property_id'], 'integer'],
            [['value'], 'string', 'max' => 254]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Название свойства',
            'value' => 'Значение',
        ];
    }
}
