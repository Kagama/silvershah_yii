<?php

namespace common\modules\order\models;

use Yii;

/**
 * This is the model class for table "t_kg_order_status_history".
 *
 * @property integer $order_id
 * @property integer $status_id
 * @property integer $date
 * @property integer $admin_id
 * @property integer $user_id
 */
class OrderStatusHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_order_status_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'status_id', 'date'], 'required'],
            [['order_id', 'status_id', 'date', 'admin_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'status_id' => 'Status ID',
            'date' => 'Date',
            'admin_id' => 'Admin ID',
            'user_id' => 'User ID',
        ];
    }
}
