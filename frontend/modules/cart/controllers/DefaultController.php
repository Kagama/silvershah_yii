<?php

namespace frontend\modules\cart\controllers;

use frontend\modules\cart\widget\CartContent;
use Yii;
use common\modules\cart\models\Cart;
use common\modules\catalog\models\Product;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Добавить товар в козину
     *
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAdd()
    {
        $prod_id = (int)\Yii::$app->request->get('id');
        $quantity = (int)\Yii::$app->request->get('quantity');
        $quantity = (empty($quantity) ? 1 : $quantity);

        if (\Yii::$app->request->isAjax) {
            $product = Product::findOne((int)$prod_id);
            if (empty($product)) {
                echo Json::encode(['error' => true, 'message' => 'Продукт не найден.']);
            } else {
                $cart = new Cart();
                if ($cart->productQuantityInc($product, $quantity)) {
                    $countStr = (string)$cart->total['quantity'];
                    $lastChar = $countStr{(strlen($countStr) - 1)};
                    if ($countStr == 1) {
                        $str = 'товар';
                    } else if (($lastChar == 2 || $lastChar == 3 || $lastChar == 4) && strlen($countStr) < 2) {
                        $str = "товара";
                    } else {
                        $str = "товаров";
                    }
                    echo Json::encode([
                        'error' => false,
                        'total' => ['quantity' => $cart->total['quantity'], 'price' => Yii::$app->formatter->asCurrency($cart->total['price'], 'RUR')],
                        'str' => $str,
                        'product_quantity' => $cart->items[$product->id]['quantity']]);
                } else {
                    echo Json::encode(['error' => true, 'message' => 'Ошибка добавления товара в карзину.']);
                }
            }
            \Yii::$app->end();

        }
    }

    /**
     * Удаление продукта из корзины
     *
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete()
    {
        if (\Yii::$app->request->isAjax) {
            $prod_id = \Yii::$app->request->get('id');

            if (($product = Product::findOne((int)$prod_id)) == null) throw new NotFoundHttpException('Продукт не найден.');

            $cart = new Cart();
            $cart->getCart();
            $deleteProductQuantity = $cart->items[$prod_id]['quantity'];
            if ($cart->deleteCartItem($product)) {
                echo Json::encode([
                    'error' => false,
                    'message' => 'Продукт удален из корзины.',
                    'total' => ['quantity' => $cart->total['quantity'], 'price' => Yii::$app->formatter->asCurrency($cart->total['price'], 'RUR')],
                    'product_quantity' => $deleteProductQuantity
                ]);
            } else {
                echo Json::encode([
                    'error' => true,
                    'message' => 'Ошибка удаления продукт из корзины.',
                ]);
            }
            \Yii::$app->end();
        }
    }

    /**
     * Удалить товар из корзины
     *
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionRemove()
    {
        if (\Yii::$app->request->isAjax) {
            $prod_id = \Yii::$app->request->get('id');

            if (($product = Product::findOne((int)$prod_id)) == null) throw new NotFoundHttpException('Продукт не найден.');
            $cart = new Cart();
            if ($cart->productQuantityDec($product)) {
                echo Json::encode([
                    'error' => false,
                    'message' => 'Количество продукта уменьшено до ' . $cart->items[$prod_id]['quantity'] . " шт.",
                    'total' => ['quantity' => $cart->total['quantity'], 'price' => Yii::$app->formatter->asCurrency($cart->total['price'], 'RUR')],
                    'product_quantity' => $cart->items[$prod_id]['quantity']
                ]);

            } else {
                echo Json::encode([
                    'error' => true,
                    'message' => 'Ошибка уменьшения количества товара.',
                ]);
            }
            \Yii::$app->end();
        }
    }

    public function actionShow()
    {
        $cart = new Cart();
        $this->render('show', ['cart' => $cart->getCart()]);
    }

    public function actionGetContent()
    {
        if (Yii::$app->request->isAjax) {
            return CartContent::widget();
        }
    }
}
