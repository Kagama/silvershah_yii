<?php

namespace common\modules\cart\models;

use common\modules\catalog\models\Product;
use Yii;

/**
 * This is the model class for table "t_kg_cart_item".
 *
 * @property integer $id
 * @property integer $cart_id
 * @property integer $product_id
 * @property double $price
 * @property integer $quantity
 */
class CartItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_cart_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cart_id', 'product_id', 'price', 'quantity'], 'required'],
            [['cart_id', 'product_id', 'quantity'], 'integer'],
            [['price'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cart_id' => 'Принадленость к корзине',
            'product_id' => 'Продукт',
            'price' => 'Price',
            'quantity' => 'Количество товаров',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
