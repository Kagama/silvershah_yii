<?php

namespace common\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\ProductProperty;

/**
 * ProductPropertySearch represents the model behind the search form about `common\modules\catalog\models\ProductProperty`.
 */
class ProductPropertySearch extends ProductProperty
{
    public function rules()
    {
        return [
            [['id', 'is_visible_to_filter', 'group_id'], 'integer'],
            [['name', 'alt_name', 'title'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductProperty::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere([
            'group_id' => $this->group_id,
        ]);

        $query->andFilterWhere([
            'is_visible_to_filter' => $this->is_visible_to_filter,
        ]);


        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alt_name', $this->alt_name])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
