<?php

namespace common\modules\catalog\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "t_kg_product_promotion_relation".
 *
 * @property integer $id
 * @property integer $promotion_id
 * @property integer $product_id
 * @property integer $position
 */
class ProductPromotionRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_promotion_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promotion_id', 'product_id'], 'required'],
            [['promotion_id', 'product_id', 'position'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promotion_id' => 'Блок провигамой продукции',
            'product_id' => 'Продукт',
            'position' => 'Прозиция отображения',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public static function addRel($promotion)
    {
        $relProds = Yii::$app->request->post('ProductPromotionRelation');
        $promotion_id = $promotion->getPrimaryKey();

        // Убераем скидку с продуктов если она имеется
        $oldRecords = static::find()->where('promotion_id = :promotion_id', [':promotion_id' => $promotion_id])->all();
        foreach ($oldRecords as $record) {
            Product::updateAll(['discount' => 0], 'id = '.$record->product_id);
        }

        // Удаляем все связи
        static::deleteAll(['promotion_id' => $promotion_id]);

        // Добавляем все связи
        if (!empty($relProds)) {
            foreach ($relProds as $prod) {
                $product_id = (int)$prod['product_id'];
                $model = new static();
                $model->promotion_id = $promotion_id;
                $model->product_id = $product_id;
                $model->position = (int)$prod['position'];
                $model->save();

                // Добавляем скидку к продукту если она имеется
                if (!empty($promotion->discount)) {
                    Product::updateAll(['discount' => $promotion->discount], 'id = '.$product_id);
                }
            }
        }
    }
}
