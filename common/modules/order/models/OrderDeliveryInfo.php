<?php

namespace common\modules\order\models;

use Yii;

/**
 * This is the model class for table "t_kg_order_delivery_info".
 *
 * @property integer $order_id
 * @property string $address
 * @property string $time
 * @property string $description
 * @property string $phone
 * @property string $flp
 */
class OrderDeliveryInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_order_delivery_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'address', 'phone', 'flp'], 'required'],
            [['order_id'], 'integer'],
            [['description'], 'string'],
            [['address', 'time', 'flp'], 'string', 'max' => 254],
            [['phone'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Номер заказа',
            'address' => 'Адрес доставки',
            'time' => 'Удобные дата и время',
            'description' => 'Дополнительная информация',
            'phone' => 'Контактный номер телефона',
            'flp' => 'Имя',
        ];
    }

    public static function findByOrderId($id)
    {
        $info = static::find()->where('order_id = :id', [':id' => $id])->one();
        if ($info == null) {
            return new static();
        }
        return $info;
    }
}
