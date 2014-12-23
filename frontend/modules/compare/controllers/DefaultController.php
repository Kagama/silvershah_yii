<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.09.14
 * Time: 15:02
 */

namespace frontend\modules\compare\controllers;

use common\modules\catalog\models\Product;
use yii\helpers\Json;
use yii\web\Controller;
use yii\helpers\Url;

class DefaultController extends Controller
{
    public function actionAdd($id)
    {
        if (\Yii::$app->request->isAjax) {
            $new_prod = Product::findOne((int)$id);

            if (empty($new_prod))
                return false;

            $_temp = \Yii::$app->session->get('compare', null);
            $_temp = unserialize($_temp);
            $compare = ($_temp == null ? [] : $_temp);

            $prod_type_and_prodArr = [];
            $exist_id = false;
            $error_message = [];

            if (count($compare) === 0) {
                $prod_type_and_prodArr[$new_prod->category_id][] = $new_prod->id;
            } else {
                for ($i = 0; $i < count($compare); $i++) {
                    if ($id == $compare[$i]) {
                        $exist_id = true;
                    }
                    $prod = Product::findOne($compare[$i]);
                    $prod_type_and_prodArr[$prod->category_id][] = $prod->id;
                }
            }

            if (count($prod_type_and_prodArr[$new_prod->category_id]) < 3) {
                if (!$exist_id) {
                    $compare[count($compare)] = $id;
                }
            } else {
                $error_message[] = 'Вы можете сравнить не более 3 товаров одной категории.';
            }
            if ($exist_id) {
                $error_message[] = 'Товар уже добавлен в сравнение.';
            }
            $_html = "";
            if (empty($error_message)) {
                $_html = '<noindex><a href="' . Url::toRoute(["/show-compare-products"]) . '" rel="nofollow"
                            class="show-compare">Сравнить (' . (count($prod_type_and_prodArr[$new_prod->category_id]) + 1) . ')</a></noindex>';
            }


            \Yii::$app->session->set('compare', serialize($compare));

//            if (\Yii::$app->request->isAjax) {
                return Json::encode([
                    'error' => (empty($error_message) ? false : $error_message),
                    '_html' => $_html
                ]);

//            }
        }
    }

    public function actionShow()
    {
        $_temp = \Yii::$app->session->get('compare', null);

        if ($_temp == null) {
            $compare = $_temp;
        } else {
            $compare = unserialize($_temp);
        }
        $products = null;
        if ($compare != null)
            foreach ($compare as $product_id) {
                $products[] = Product::findOne((int)$product_id);
            }
        return $this->render('show', [
            'products' => $products
        ]);
    }

    public function actionRemove($id)
    {
        $_temp = \Yii::$app->session->get('compare', []);
        if (!empty($_temp)) {
            $compare = unserialize($_temp);
        } else {
            $compare = $_temp;
        }
        $tempArr = array();
        for ($i = 0; $i < count($compare); $i++) {
            if ($id != $compare[$i]) {
                $tempArr[] = $compare[$i];
            }
        }
        $compare = $tempArr;

        \Yii::$app->session->set('compare', serialize($compare));
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}