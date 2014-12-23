<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.08.14
 * Time: 14:44
 */

namespace frontend\modules\order\models;

use common\modules\cart\models\Cart;
use common\modules\order\models\Order;
use common\modules\user\models\User;
use Yii;
use yii\base\Model;

class CreateOrderForm extends Model
{
    public $phone_number;
    public $username;
    public $new_user_is_reg = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['phone_number', 'username'], 'required'],
            [['phone_number'], 'string', 'max' => 16],
            [['phone_number'], 'match', 'pattern' => '/^\+7\([0-9]{3}\)[0-9]{3}\-[0-9]{2}[0-9]{2}$/i', 'message' => '"Мобильный номер тел." должен быть записан следующим образом: +7(999) 999-9999'],
            [['username'], 'string', 'max' => 254],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone_number' => 'Мобильный номер тел.',
            'username' => 'Имя'
        ];
    }

    public function saveOrder(Cart $cart)
    {
        $user = User::findByProperties(['phone' => $this->phone_number]);
        if (empty($user)) {
            $user = User::registerByPhoneNumber($this->phone_number, $this->username);
            $this->new_user_is_reg = true;
        }

        $order = new Order();
        $order->status = 1; // Новый заказа
        $order->date = time();
        $order->user_id = $user->getPrimaryKey();
        if ($order->save()) {
            return $cart->saveCart($order->getPrimaryKey(), $user->getPrimaryKey());
        }
        return null;
    }
}