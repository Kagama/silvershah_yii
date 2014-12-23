<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 26.08.14
 * Time: 15:36
 */
namespace frontend\modules\user\controllers;

use common\modules\catalog\models\ProductWishList;
use common\modules\order\models\Order;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\modules\user\models\User;

class CabinetController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'profile', 'change-password', 'history', 'wish-list'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'profile', 'change-password', 'history', 'wish-list'],
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $render_template = "index";

        $orders = Order::find()->where('status = 1 and user_id = :id', [':id' => \Yii::$app->user->getId()])->all();


        return $this->render('index', [
            'render_template' => $render_template,
            'orders' => $orders
        ]);
    }

    public function actionProfile()
    {
        $render_template = "profile";

        $user = User::findOne(\Yii::$app->user->getId());

        if ($user->load(\Yii::$app->request->post())) {
            if ($user->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Информация сохранена.');
            } else {
                \Yii::$app->getSession()->setFlash('error', 'Ошибка созранения информации');
            }
        }

        return $this->render('index', [
            'render_template' => $render_template,
            'user' => $user
        ]);
    }

    public function actionChangePassword()
    {
        $render_template = "change_password";

        $user = User::findOne(\Yii::$app->user->getId());
        $user->scenario = 'changePassword';
        $old_password = $user->password;

        if ($user->load(\Yii::$app->request->post())) {
            if ($old_password != $_POST['User']['old_password']) {
                $user->addError('old_password', 'Старый пароль введен не верно.');
            } else {
                if ($user->save()) {
                    \Yii::$app->getSession()->setFlash('success', 'Пароль изменен.');
                } else {
                    \Yii::$app->getSession()->setFlash('error', 'Ошибка изменения пароля.');
                }
            }

        }

        return $this->render('index', [
            'render_template' => $render_template,
            'user' => $user
        ]);
    }

    public function actionHistory()
    {
        $render_template = "history";

        $orders = Order::find()->where('(status = 4 or status = 5 or status = 6 or status = 7) and user_id = :id', [':id' => \Yii::$app->user->getId()])->all();

        return $this->render('index', [
            'render_template' => $render_template,
            'orders' => $orders
        ]);
    }

    public function actionWishList()
    {
        $render_template = "wish-list";

        $wishObj = ProductWishList::find()->where(' user_id = :id', [':id' => \Yii::$app->user->getId()])->all();

        return $this->render('index', [
            'render_template' => $render_template,
            'wishObj' => $wishObj
        ]);
    }
}