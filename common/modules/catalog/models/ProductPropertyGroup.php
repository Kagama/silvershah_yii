<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "t_kg_product_property_group".
 *
 * @property integer $id
 * @property string $backend_name
 * @property string $frontend_name
 */
class ProductPropertyGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_property_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['backend_name', 'frontend_name'], 'required'],
            [['backend_name', 'frontend_name'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'backend_name' => 'Название отображется в адм. панеле',
            'frontend_name' => 'Название отображается на сайте',
        ];
    }

    public function getProperties()
    {
        return $this->hasMany(ProductProperty::className(), ['group_id' => 'id']);
    }
}
