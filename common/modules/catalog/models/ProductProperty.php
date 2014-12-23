<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "t_kg_product_property".
 *
 * @property integer $id
 * @property string $name
 * @property string $alt_name
 * @property string $title
 * @property integer $is_visible_to_filter
 * @property integer $group_id
 */
class ProductProperty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alt_name', 'title', 'group_id'], 'required'],
            [['alt_name'], 'unique'],
            [['is_visible_to_filter', 'group_id'], 'integer'],
            [['name', 'alt_name', 'title'], 'string', 'max' => 254]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'alt_name' => 'Альтернативное название свойства',
            'title' => 'Заголовок свойства для отображение в админ панели',
            'is_visible_to_filter' => 'Отображать в фильтре товаров',
            'group_id' => 'Группа свойств'
        ];
    }

    public function getGroup()
    {
        return $this->hasOne(ProductPropertyGroup::className(), ['id' => 'group_id']);
    }

}
