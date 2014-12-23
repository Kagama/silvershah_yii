<?php

namespace common\modules\cart\models;

use common\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "t_kg_cart".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property string $session_id
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * Список продуктов
     * @var array
     */
    public $items = array();

    /**
     * @var array
     */
    public $total = array('price' => 0, 'quantity' => 0);

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id'], 'required'],
            [['order_id', 'user_id'], 'integer'],
            [['session_id'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'user_id' => 'Авторизованный Пользователь',
            'session_id' => 'Номер сессии',
        ];
    }

    /**
     * Увеличиваем количество одного продукта.
     * Сохраняем в сессии.
     *
     * @param $product
     * @param int $quantity
     * @return bool
     */
    public function productQuantityInc($product, $quantity = 1)
    {
        $price = 0;
        $this->getCart();

        if (empty($this->items[$product->id])) {
            $price = $product->price;
            $this->items[$product->id] = ['id' => $product->id, 'quantity' => $quantity, 'price' => $product->price];
        } else {
            $price = $this->items[$product->id]['price'];
            $this->items[$product->id]['quantity'] += $quantity;
        }
        $this->total['price'] += ($quantity * $price);
        $this->total['quantity'] += $quantity;

        return $this->setCart(['items' => $this->items, 'total' => $this->total]);
    }

    /**
     * Уменьшаем количество одно продукта.
     * Изменения сохраняем в сессии.
     *
     * @param $product
     * @param int $quantity
     */
    public function productQuantityDec($product, $quantity = 1)
    {
        $this->getCart();
        $oldCart = $this->items;
        if ($this->items[$product->id]['quantity'] > 1) {
            $this->items[$product->id]['quantity'] -= $quantity;
            $this->total['price'] -= ($quantity * $this->items[$product->id]['price']);
            $this->total['quantity'] -= $quantity;
            $this->setCart(['items' => $this->items, 'total' => $this->total]);

            return !($oldCart === ['items' => $this->items, 'total' => $this->total]);
        }
        return false;
    }

    /**
     * Удаляем товар с корзины.
     *
     * @param $product
     */
    public function deleteCartItem($product)
    {
        $this->getCart();
        $oldCart = $this->items;
        foreach ($this->items as $item) {
            if ($item['id'] == $product->id) {
                $price = (intval($item['quantity']) * $product->price);
                $this->total['price'] = $this->total['price'] - $price;
                $this->total['quantity'] = $this->total['quantity'] - $item['quantity'];
                unset($this->items[$product->id]);
            }
        }
        $this->setCart(['items' => $this->items, 'total' => $this->total]);
        return !($oldCart === ['items' => $this->items, 'total' => $this->total]);
    }

    /**
     * Сохраняем данные о корзине в сессии
     *
     * @param $cart
     * @return bool
     */
    public function setCart($cart)
    {
        $cart = serialize($cart);
        Yii::$app->session->set('userCart', $cart);
        return true;
    }

    /**
     * Получаем корзину из сессии
     *
     * @return $this|null
     */
    public function getCart()
    {
        $cart = unserialize(Yii::$app->session->get('userCart'));
        if (empty($cart)) {
            return $this;
        } else {
            $this->items = $cart['items'];
            $this->total = $cart['total'];
            return $this;
        }
        return null;
    }

    /**
     * Сохраняем корзину в базе даных.
     *
     * @param $order_id
     * @return bool
     */
    public function saveCart($order_id, $user_id = null)
    {
        $this->order_id = $order_id;
        $this->user_id = $user_id;

        if ($this->save()) {
            $cart_id = $this->getPrimaryKey();

            foreach ($this->items as $item) {
                $cart_items = new CartItem();
                $cart_items->setIsNewRecord(true);
                $cart_items->cart_id = $cart_id;
                $cart_items->product_id = intval($item['id']);
                $cart_items->price = intval($item['price']);
                $cart_items->quantity = intval($item['quantity']);
                if ($cart_items->save()) {
                    unset($cart_items);
                } else {
                    return false;
                }
            }
            return true;
        }
        return false;

    }

    public function getCartItems()
    {
        return $this->hasMany(CartItem::className(), ['cart_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'id']);
    }

    public function getTotalQuantity()
    {
        return $this->total['quantity'];
    }

    public function getTotalSum()
    {
        return Yii::$app->formatter->asCurrency($this->total['price'], 'RUR');
    }
}
