<?php

namespace common\modules\catalog\models\search;

use common\modules\catalog\models\ProductCategory;
use common\modules\catalog\models\ProductCategoryRelation;
use common\modules\catalog\models\ProductPropertyValueRelation;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\Product;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\data\Sort;
use yii\data\SqlDataProvider;

/**
 * ProductSearch represents the model behind the search form about `common\modules\catalog\models\Product`.
 */
class ProductSearch extends Product
{
    public function rules()
    {
        return [
            [['id', 'manufacture_id', 'quantity', 'product_type_id', 'visible', 'rate', 'rate_count', 'pre_order'], 'integer'],
            [['code_number', 'model', 'name', 'alt_name', 'h1_name', 'description', 'seo_title', 'seo_keywords', 'seo_description'], 'safe'],
            [['old_price', 'price'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Общий поиск продуктов
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'manufacture_id' => $this->manufacture_id,
            'old_price' => $this->old_price,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'product_type_id' => $this->product_type_id,
            'visible' => $this->visible,
            'rate' => $this->rate,
            'rate_count' => $this->rate_count,
            'pre_order' => $this->pre_order,
        ]);

        $query->andFilterWhere(['like', 'code_number', $this->code_number])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alt_name', $this->alt_name])
            ->andFilterWhere(['like', 'h1_name', $this->h1_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description]);

        return $dataProvider;
    }


    /**
     * Поиск продуктов + условия выборки через фильтр
     *
     * @param $params
     * @param $PropertyFilter - Значения своство продкта. Значения получаем через GET
     * @return ActiveDataProvider
     */
    public function searchWithFilter($params, $PropertyFilter, $category_id)
    {
        $pageSize = 10000;

        $sort = new Sort([
            'attributes' => [
//                'name' => [
//                    'asc' => ['name' => SORT_ASC],
//                    'desc' => ['name' => SORT_DESC],
//                    'default' => SORT_ASC,
//                    'label' => 'названию',
//                ],
                'price' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'цена',
                ]
            ],
        ]);


        if (!empty($PropertyFilter)) {
            // Версия 1
            /*$query = Product::find();
            foreach ($PropertyFilter as $propertyName) {
                $query->union("Select " . Product::tableName() . ".*
                    From " . Product::tableName() . "
                    Left Join " . ProductPropertyValueRelation::tableName() . " ppvr ON ppvr.product_id = " . Product::tableName() . ".id
                    Where (ppvr.property_value_id = " . implode(' or ppvr.property_value_id = ', $propertyName).") and
                    " . Product::tableName() . ".category_id = ".$category_id);

            }*/

            // Версия 2
            /*$sql = "";
            foreach ($PropertyFilter as $propertyName) {
                $sql .= ($sql == "" ? "" : ") UNION (") . "
                    Select " . Product::tableName() . ".*
                    From " . Product::tableName() . "
                    Left Join " . ProductPropertyValueRelation::tableName() . " ppvr ON ppvr.product_id = " . Product::tableName() . ".id
                    Where (ppvr.property_value_id = " . implode(' or  ppvr.property_value_id = ', $propertyName) . ") and " . Product::tableName() . ".category_id = ".$category_id;
            }
            if ($sql != "") {
                $sql = "(" . $sql . ")";
            }
            echo $sql;
            $query = Product::findBySql($sql);
            */

            // Версия 3
            /**
             * Фильтр по свойствам товара
             */
            $sql = " Select * From " . Product::tableName() . " ";
//            $sql_count = " Select count(id) From " . Product::tableName() . " ";
            $sql_where = " Where  ";
            $where = "";
            foreach ($PropertyFilter as $index => $propertyName) {
                if ($index == 'price' || $index == 'manufacturer' || $index == 'search-text') continue;
                $where .= ($where == "" ? " " : " and ") . " id IN ( Select product_id From " . ProductPropertyValueRelation::tableName() . " Where property_value_id = " . implode(' or  property_value_id = ', $propertyName) . " ) ";
            }

            /**
             * Добавили поиск по тексту
             */
            if (isset($PropertyFilter['search-text'])) {
                $where .= ($where == "" ? " " : " and ") . " (
                    code_number like '%".$PropertyFilter['search-text']."%' OR
                    name like '%".$PropertyFilter['search-text']."%' OR
                    h1_name like '%".$PropertyFilter['search-text']."%' OR
                    description like '%".$PropertyFilter['search-text']."%' OR
                    overview like '%".$PropertyFilter['search-text']."%')";

            }

            /**
             * Добавили фильтр по производителю
             */
            if (isset($PropertyFilter['manufacturer'])) {
                $where .= ($where == "" ? " " : " and ") . " ( manufacture_id = " . implode(' or  manufacture_id = ', $PropertyFilter['manufacturer']) . ")";

            }

            /**
             *  Добавили фильтр по цене
             */
            if (isset($PropertyFilter['price'])) {
                $where .= ($where == "" ? " " : " and ") . " ( price >= " . $PropertyFilter['price']['min'] . " and price <= " . $PropertyFilter['price']['max'] . ")";
            }

            /**
             * Добавили выборку по категории
             */
            if ($category_id != null) {
                $where .= ($where == "" ? " " : " and ") . " id IN ( Select product_id From " . ProductCategoryRelation::tableName() . " Where category_id = " . $category_id . ")";
            }
            /**
             *
             */

            $where .= ($where == "" ? " " : " and ") . " visible = 1 ";


            $sql_where .= $where;
            $sql .= $sql_where;
//            $sql_count .= $sql_where;

            // Сортировка
//            $sortArr = $sort->getOrders();
//            $orderBy = "";
//            if (!empty($sortArr)) {
//                foreach ($sortArr as $_f => $_type) {
//                    $orderBy = " Order By ".$_f." ".($_type == SORT_DESC ? "desc" : "asc");
//                }
//
//            }
//            $sql .= $orderBy;

//            $query = Product::findBySql($sql);

            $dataProvider = new ArrayDataProvider([
                'allModels' => Product::findBySql($sql)->all(),
                'sort' => $sort,
                'pagination' => [
                    'pageSize' => $pageSize,
                ],
            ]);


        } else {

            $query = Product::find();
            $query->leftJoin(ProductCategoryRelation::tableName(), Product::tableName() . '.id = ' . ProductCategoryRelation::tableName() . '.product_id');
            $query->where(ProductCategoryRelation::tableName() . ".category_id = " . $category_id);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => $sort,
                'pagination' => [
                    'pageSize' => $pageSize
                ]
            ]);
        }


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        return $dataProvider;
    }

    public function findMaxAndMinPrice($_category_id)
    {
        $sql = " Select MAX(price) as max_price, MIN(price) as min_price From " . Product::tableName() . " ";
//            $sql_count = " Select count(id) From " . Product::tableName() . " ";
        $sql_where = " Where  ";
        $where = "";
        /**
         * Добавили выборку по категории
         */
        if ($_category_id != null) {
            $where .= ($where == "" ? " " : " and ") . " id IN ( Select product_id From " . ProductCategoryRelation::tableName() . " Where category_id = " . $_category_id . ")";
        }
        /**
         *
         */

        $where .= ($where == "" ? " " : " and ") . " visible = 1 ";


        $sql_where .= $where;
        $sql .= $sql_where;

        $query = Product::findBySql($sql)->asArray()->one();
        return (empty($query) ? null : $query );
    }
}
