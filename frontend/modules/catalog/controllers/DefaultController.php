<?php

namespace frontend\modules\catalog\controllers;

use common\modules\catalog\models\Product;
use common\modules\catalog\models\ProductCategory;
use common\modules\catalog\models\ProductWishList;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionShow($id, $code_h1)
    {

        $model = Product::findOne($id);
        if ($model == null)
            throw new NotFoundHttpException('Продукт не найдет.');



        if (\Yii::$app->request->cookies->has('i_saw_this_product')) {
            $cookie = \Yii::$app->request->cookies->get('i_saw_this_product');

            $value = unserialize($cookie->value);
            if (!in_array($id, $value)) {

                $value[] = $id;
                $cookie->value = serialize($value);
                $cookie->expire = time() + 2592000; // 30 дней хранить cookie о просмотре новости
                \Yii::$app->response->cookies->add($cookie);
            }
        } else {
            $cookie = new Cookie();
            $cookie->name = 'i_saw_this_product';
            $cookie->value = serialize([$id]);
            $cookie->expire = time() + 2592000; // 30 дней хранить cookie о просмотре новости
            \Yii::$app->response->cookies->add($cookie);
        }

        return $this->render('show', [
            'model' => $model
        ]);
    }

    public function actionAddToWishList($id)
    {
        $product = Product::findOne((int)$id);
        if (\Yii::$app->user->isGuest || empty($product))
            $this->goHome();

        $user = \Yii::$app->user->getId();

        $wish = new ProductWishList();
        $wish->user_id = $user;
        $wish->product_id = $product->id;

        if ($wish->save()) {
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            throw new Exception($wish->getErrors(), 404);
        }

    }

    public function actionAddToFavorite()
    {
        if (\Yii::$app->request->isAjax) {
            // get the cookie collection (yii\web\CookieCollection) from the "response" component
            $id = \Yii::$app->request->get("id");

            if (\Yii::$app->request->cookies->has('favorite')) {
                $cookie = \Yii::$app->request->cookies->get('favorite');

                $value = unserialize($cookie->value);
                if (!in_array($id, $value)) {

                    $value[] = $id;
                    $cookie->value = serialize($value);
                    $cookie->expire = time() + 2592000; // 30 дней хранить cookie о просмотре новости
                    \Yii::$app->response->cookies->add($cookie);
                }
            } else {
                $cookie = new Cookie();
                $cookie->name = 'favorite';
                $cookie->value = serialize([$id]);
                $cookie->expire = time() + 2592000; // 30 дней хранить cookie о просмотре новости
                \Yii::$app->response->cookies->add($cookie);
            }
        }
    }



    public function actionFavorite()
    {
        $favorite = \Yii::$app->request->cookies->getValue('favorite');

        $ids = unserialize($favorite);



        if (empty($ids)) {
            $query = null;

            return $this->render('favorite', [
                'category' => null,
                'dataProvider' => null,
                'product_type' => null,
                'productViewStyle' => false,
            ]);

        } else {
            $query = Product::find();
            $query->where('id in (' . implode(',', $ids) . ')');
        }



        $sort = new Sort([
            'attributes' => [
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'названию',
                ],
                'price' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'цена',
                ]
            ],
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);


        return $this->render('favorite', [
            'category' => null,
            'dataProvider' => $dataProvider,
            'product_type' => null,
            'productViewStyle' => false,
        ]);
    }
}
