<?php

namespace frontend\modules\order\controllers;

use common\modules\catalog\models\Product;
use common\modules\user\models\User;
use Yii;
use common\modules\cart\models\Cart;
use frontend\modules\order\models\CreateOrderForm;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {

        $model = new CreateOrderForm();
        $cart = new Cart();
        $cart->getCart();
        if (empty($cart->items)) {
            $this->redirect(Url::home());
        }
        $order_create = false;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (($result = $model->saveOrder($cart)) === true) {
                $order_create = true;
                return Json::encode(['error' => false, 'html' => $this->renderPartial('create', ['model' => $model, 'cart' => $cart, 'order_create' => $order_create])]);
//                Yii::$app->session->setFlash('order_success_create', true);
//                if ($model->new_user_is_reg) {
//                    Yii::$app->session->setFlash('order_reg_new_user', true);
//                }
//                $model->phone_number = null;
            }
            if ($result instanceof User && $result->hasErrors()) {
                print_r($result->hasErrors());
            }
        }

        if (Yii::$app->request->isAjax) {
            return Json::encode(['error' => true, 'html' => $this->renderPartial('create', ['model' => $model, 'cart' => $cart, 'order_create' => $order_create])]);
//            return $this->renderAjax('create', ['model' => $model, 'cart' => $cart, 'order_create' => $order_create]);
//            Yii::$app->end();
        } else {
            $this->goHome();
        }

    }

    public function actionFast($id)
    {
        $model = new CreateOrderForm();
        $cart = new Cart();
        $cart->getCart();

        // Проверяем наличие продукта
        $product = Product::findOne((int) $id);
        if (empty($product))
            throw new NotFoundHttpException('Продукт не найден.');

        if (empty($cart->items)) $cart->productQuantityInc($product);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (($result = $model->saveOrder($cart)) === true) {
                Yii::$app->session->setFlash('order_success_create', true);
                if ($model->new_user_is_reg) {
                    Yii::$app->session->setFlash('order_reg_new_user', true);
                }
                $model->phone_number = null;
            }
        }
        if ($result instanceof User && $result->hasErrors()) {
            //print_r($result->hasErrors());
        }

        return $this->render('fast', ['model' => $model, 'cart' => $cart]);
    }
}
