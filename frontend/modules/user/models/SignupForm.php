<?php
namespace frontend\modules\user\models;

use common\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $phone;
//    public $password;
//    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'],  'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['phone'],'required'],
            [['phone'], 'unique', 'targetClass' => 'common\modules\user\models\User', 'message' => 'Пользователь с таким номером моб. телефона уже имеется зарегистрирован.'],
//            [['password', 'password_repeat'], 'string', 'min' => 2, 'max' => 32],
//            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'operator' => '=='],
            [['phone'], 'string', 'min' => 16],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Моб. номер телефона',
//            'password' => 'Пароль',
//            'password_repeat' => 'Повторите пароль'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            return User::registerByPhoneNumber($this->phone);
        }

        return null;
    }
}
