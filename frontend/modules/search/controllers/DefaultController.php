<?php

namespace frontend\modules\search\controllers;

use common\modules\catalog\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $search_text = \Yii::$app->request->get('search_text');
        $query = Product::find();

        $dataProvider  = new ActiveDataProvider([
            'query' => $query
        ]);

        $query->orFilterWhere(['like', 'code_number', $search_text])
            ->orFilterWhere(['like', 'model', $search_text])
            ->orFilterWhere(['like', 'name', $search_text])
            ->orFilterWhere(['like', 'alt_name', $search_text])
            ->orFilterWhere(['like', 'h1_name', $search_text])
            ->orFilterWhere(['like', 'description', $search_text])
            ->orFilterWhere(['like', 'overview', $search_text])
            ->orFilterWhere(['like', 'seo_title', $search_text])
            ->orFilterWhere(['like', 'seo_keywords', $search_text])
            ->orFilterWhere(['like', 'seo_description', $search_text]);

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
        $dataProvider->pagination->pageSize = 20;

        return $this->render('index',[
            'dataProvider' => $dataProvider
        ]);
    }
}
