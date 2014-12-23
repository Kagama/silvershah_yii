<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.09.14
 * Time: 15:06
 */

namespace frontend\modules\catalog\controllers;

use common\modules\catalog\models\Product;
use common\modules\catalog\models\ProductComment;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommentController extends Controller
{

    public function actionIndex($product_id)
    {
        $product = Product::findOne((int)$product_id);
        if (empty($product))
            throw new NotFoundHttpException('Номер продукта не указан.');

        $comments = ProductComment::find()->
            where('approve = 1 and product_id = :id', [':id' => $product->id])->
            orderBy("date DESC")->
            all();

        return $this->renderPartial('index', [
            'comments' => $comments,
            'product_id' => $product_id
        ]);
    }

    public function actionAdd()
    {
        if (\Yii::$app->request->isAjax) {
            $model = new ProductComment();
            if ($model->load(\Yii::$app->request->post()) && $model->save()) {
                return Json::encode(['error' => false, 'success' => '<strong>Спасибо! Ваш отзыв добавлен.</strong><br />После премодерации Ваш отзыв будет выведен на сайт.']);
            }

            return Json::encode(['error' => false, 'content' => $this->renderPartial('add', [
                    'model' => $model
                ])]);
        } else {
            $this->goHome();
        }
    }
}