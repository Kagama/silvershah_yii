<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "t_kg_product_up_sell".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $related_product_id
 * @property integer $position
 */
class ProductUpSell extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_up_sell';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'related_product_id', 'position'], 'required'],
            [['product_id', 'related_product_id', 'position'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Продукт',
            'related_product_id' => 'Продвигаемый продукт',
            'position' => 'Позиция',
        ];
    }

    public static function addRel($product_id)
    {
        $relProds = Yii::$app->request->post('ProductUpSell');

        // Удаляем все связи
        ProductUpSell::deleteAll(['product_id' => $product_id]);

        // Добавляем все связи
        if (!empty($relProds)) {
            foreach ($relProds as $prod) {
                $model = new ProductUpSell();
                $model->product_id = $product_id;
                $model->related_product_id = (int)$prod['related_product_id'];
                $model->position = (int)$prod['position'];
                $model->save();
            }
        }
    }

    // Продукт
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'related_product_id']);
    }
}
