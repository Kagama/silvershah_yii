<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 30.06.14
 * Time: 16:25
 */
namespace frontend\modules\catalog\controllers;

use common\modules\catalog\models\Product;
use common\modules\catalog\models\ProductCategory;
use common\modules\catalog\models\search\ProductSearch;

use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{


    public function actionIndex($cat_url)
    {
        $category = ProductCategory::find()->
        where(' url = :url', [':url' => str_replace("-", "_", $cat_url)])->
        one();

        if (empty($category))
            throw new NotFoundHttpException('Страница не найден');

        /**
         * Получаем свойства продукта из фильтра для дальнейшей выборки
         */
        $PropertyFilter = \Yii::$app->request->get('PropertyFilter');

        /**
         * Получаем продукты
         */
        $searchModel = new ProductSearch();

        $priceRange = $searchModel->findMaxAndMinPrice($category->id);

        $dataProvider = $searchModel->searchWithFilter(\Yii::$app->request->getQueryParams(), $PropertyFilter, $category->id);
        //$dataProvider->query->andFilterWhere(['category_id' => $category->id]);
//        $dataProvider->setSort([
//            'attributes' => [
//                'name' => [
//                    'asc' => ['name' => SORT_ASC],
//                    'desc' => ['name' => SORT_DESC],
//                    'default' => SORT_ASC,
//                    'label' => 'названию',
//                ],
//                'price' => [
//                    'asc' => ['price' => SORT_ASC],
//                    'desc' => ['price' => SORT_DESC],
//                    'default' => SORT_ASC,
//                    'label' => 'цена',
//                ]
//            ],
//        ]);
//        $dataProvider->pagination->pageSize = 2;


        /**
         * TODO Быбираем тип продукта. Если типов будет два то нужно вывести пересечение сковст продуктов
         */
//        $any_product = Product::find()->where(' category_id = :id', [':id' => $category->id])->one();
//        $product_type = $any_product->product_type_id;
        if ($dataProvider->getModels()) {
            $product_type = $dataProvider->getModels()[0]->product_type_id;
        } else {
            $product_type = null;
        }


        return $this->render('index', [
            'category' => $category,
            'dataProvider' => $dataProvider,
            'product_type' => $product_type,
            'PropertyFilter' => $PropertyFilter,
            'priceRange' => $priceRange,
            'productViewStyle' => false,
        ]);
    }


}