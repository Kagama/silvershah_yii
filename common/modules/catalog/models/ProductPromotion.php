<?php

namespace common\modules\catalog\models;

use common\helpers\CString;
use Yii;

/**
 * This is the model class for table "t_kg_product_promotion".
 *
 * @property integer $id
 * @property string $name
 * @property string $alt_name
 * @property integer $position
 * @property integer $active
 * @property double $discount
 * @property integer $main_promo_block
 * @property integer $prod_of_the_day
 */
class ProductPromotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['position', 'active', 'main_promo_block', 'prod_of_the_day'], 'integer'],
            [['discount'], 'double'],
            [['name', 'alt_name'], 'string', 'max' => 254],
            [['name'], 'unique']
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
            'alt_name' => 'Alt Название',
            'position' => 'Позиция',
            'active' => 'Состояние',
            'discount' => 'Скидка',
            'main_promo_block' => 'Главный продвигаемый блок',
            'prod_of_the_day' => 'Продукт дня'
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->alt_name = CString::translitTo($this->name);
            return true;
        }
        return false;
    }

    public function getPromoProdRel()
    {
        return $this->hasMany(ProductPromotionRelation::className(), ['promotion_id' => 'id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        ProductPromotionRelation::addRel($this);
        parent::afterSave($insert, $changedAttributes);
    }
}
