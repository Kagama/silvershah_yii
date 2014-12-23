<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "t_kg_product_type".
 *
 * @property integer $id
 * @property string $name
 */
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 254]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Название',
        ];
    }

    public function  getProperties() {

        return $this->hasMany(ProductProperty::className(), ['id' => 'property_id'])
            ->viaTable(ProductTypePropertyRelation::tableName(), ['type_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes) {

        $properties = Yii::$app->request->post('ProductProperty'); //Yii::app()->request->getParam('ProductProperty');

        $ProductTypePropertyRelation = Yii::$app->request->post('ProductTypePropertyRelation'); //Yii::app()->request->getParam('ProductTypePropertyRelation');

        $relation = new ProductTypePropertyRelation;

        /**
         * Получаем все связи типа продукта и свойств
         */
        $all_rel = $relation->find()->where(['type_id' => $this->getPrimaryKey()])->all();// findAllByAttributes(array('type_id' => $this->getPrimaryKey()));
        if (empty($all_rel)) {
            /**
             * Если всязей нет то записываем связи в таблицу ProductTypePropertyRelation
             */
            foreach ($properties as $index => $property) {
                $relation->setIsNewRecord(true);
                $relation->type_id = $this->getPrimaryKey();
                $relation->property_id = intval($property);
                $relation->property_group_id = $ProductTypePropertyRelation[intval($property)]['property_group_id'];
                $relation->position_number = $ProductTypePropertyRelation[intval($property)]['position_number'];
                $relation->save();
            }
        } else {
            /**
             * Если связи имеются то:
             * 1. Удаляем все свойства которые отменены
             * 2. Добавляем все новые свойства
             */
            /**
             *  Шаг 1.
             */
            ProductTypePropertyRelation::deleteAll(['type_id' => $this->getPrimaryKey()]);   //model()->deleteAllByAttributes(array('type_id' => $this->getPrimaryKey()));
            /**
             * Шаг 2.
             */
            foreach ($properties as $index => $property) {
                $relation->setIsNewRecord(true);
                $relation->type_id = $this->getPrimaryKey();
                $relation->property_id = intval($property);
                $relation->property_group_id = $ProductTypePropertyRelation[intval($property)]['property_group_id'];
                $relation->position_number = $ProductTypePropertyRelation[intval($property)]['position_number'];
                $relation->save();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }
}
