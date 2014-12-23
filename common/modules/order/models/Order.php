<?php

namespace common\modules\order\models;

use backend\modules\admin\models\AdminUsers;
use common\modules\cart\models\Cart;
use common\modules\catalog\models\Product;
use common\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "t_kg_order".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $date
 * @property integer $user_id
 */
class Order extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'date', 'user_id'], 'integer'],
            [['date'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Статус выполенния',
            'date' => 'Дата создания заказа',
            'user_id' => 'Пользователь'
        ];
    }

    public function getStatusName()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'status']);
    }

    public function getCart()
    {
        return $this->hasOne(Cart::className(), ['order_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function totalPriceByUser($user_id)
    {
        $orders = static::find()->where('user_id = :id', [':id' => $user_id])->all();
        $total_price = 0;
        foreach ($orders as $order) {
            $cart = $order->cart;
            foreach ($cart->cartItems as $item) {
                $total_price += ($item->quantity * $item->price);
            }
        }
        return \Yii::$app->formatter->asCurrency($total_price, 'RUR');
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            /**
             * Если статус изменился то сохряем историю статусов
             */
            if ($this->status != $this->getOldAttribute('status')) {
                $history = new OrderStatusHistory();
                $history->order_id = $this->getPrimaryKey();
                $history->status_id = $this->status;
                $history->date = time();

                if (Yii::$app->user->getIdentity() instanceof AdminUsers) {
                    $history->admin_id = Yii::$app->user->getId();
                    $history->user_id = null;
                }
                if (Yii::$app->user->getIdentity() instanceof User) {
                    $history->admin_id = null;
                    $history->user_id = Yii::$app->user->getId();
                }

                $history->save();
                if ($history->hasErrors()) {
//                    print_r($history->getErrors());
                }
            }
            /**
             * Если статуст заказа "Завершён" то:
             * 1. Просматриваем все товары в корзине
             * 2. Уменьшаем количество товара "quantity" в таблице продктов Product
             */
            if (($this->status != $this->getOldAttribute('status')) && $this->status == 4) { // Завершён
                $cartItems = $this->cart->cartItems;
                foreach ($cartItems as $item) {
                    Product::updateAll(['quantity' => (Product::findOne($item->product_id)->quantity - 1)], 'id = '.$item->product_id);
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
