<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "t_kg_product_comment".
 *
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $text
 * @property integer $owner_id
 * @property integer $date
 * @property integer $like_count
 * @property integer $unlike_count
 * @property integer $product_id
 * @property integer $approve
 * @property integer $level
 * @property integer $rate
 */
class ProductComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'username', 'text', 'rate'], 'required'],
            [['text'], 'string'],
            [['owner_id', 'date', 'like_count', 'unlike_count', 'product_id', 'approve', 'level', 'rate'], 'integer'],
            [['email', 'username'], 'string', 'max' => 254],
            [['email'], 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email пользователя',
            'username' => 'Имя пользователя ',
            'text' => 'Текст',
            'owner_id' => 'Id отцовского комментария',
            'date' => 'Дата добавления',
            'like_count' => 'Количество кликов нравиться',
            'unlike_count' => 'Количество отметок не нравиться',
            'product_id' => 'Номер продукта',
            'approve' => 'Одобрено',
            'level' => 'Уровень вложенности',
            'rate' => 'Рейтинг',
        ];
    }

    public function afterFind()
    {
        $this->date = date('d.m.Y', $this->date);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->date = strtotime($this->date);
            return true;
        }
        return false;
    }
}
