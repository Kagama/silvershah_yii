<?php

namespace frontend\modules\catalog\controllers;

use common\modules\catalog\models\Product;
use common\modules\catalog\models\ProductPromotion;
use common\modules\catalog\models\ProductPromotionRelation;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PromotionController extends Controller
{
    public function actionIndex($id_alt_name)
    {
        $vars = explode("_", $id_alt_name);

        $promotionModel = ProductPromotion::findOne((int) $vars[0]);

        if (empty($promotionModel))
            throw new NotFoundHttpException('Страница не найдена.');

        $products_query = Product::findBySql('
            select prod.*
            from '.Product::tableName().' prod
            left join '.ProductPromotionRelation::tableName().' rel on prod.id = rel.product_id and rel.promotion_id = '.$promotionModel->id.'
        ');

        $dataProvider = new ActiveDataProvider();
        $dataProvider->query = $products_query;
        $dataProvider->pagination->pageSize = 20;
        $dataProvider->setSort([
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

        return $this->render('index',[
                'promotionModel' => $promotionModel,
                'dataProvider' => $dataProvider
            ]
        );
    }
}
