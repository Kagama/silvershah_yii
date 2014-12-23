<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "t_kg_product_related_products".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $related_product_id
 * @property integer $position
 */
class ProductsRelatedProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_related_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'related_product_id'], 'required'],
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
            'product_id' => 'Product ID',
            'related_product_id' => 'Related Product ID',
            'position' => 'Position',
        ];
    }

    public static function addRel($product_id)
    {
        $relProds = Yii::$app->request->post('ProductsRelatedProduct');


        // Удаляем все связи
        ProductsRelatedProduct::deleteAll(['product_id' => $product_id]);
        // Добавляем все связи
        if (!empty($relProds)) {
            foreach ($relProds as $prod) {
                $model = new ProductsRelatedProduct();
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
