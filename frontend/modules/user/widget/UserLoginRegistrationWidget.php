<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.08.14
 * Time: 17:28
 */

namespace frontend\modules\user\widget;

use yii\base\Widget;

class UserLoginRegistrationWidget extends Widget
{
    public function run()
    {

        return $this->render('_user_login_registration');
    }
}