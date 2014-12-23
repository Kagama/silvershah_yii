<?php

namespace common\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\ProductPropertyGroup;

/**
 * ProductPropertySearch represents the model behind the search form about `common\modules\catalog\models\ProductProperty`.
 */
class ProductPropertyGroupSearch extends ProductPropertyGroup
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['backend_name', 'frontend_name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductPropertyGroup::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);


        $query->andFilterWhere(['like', 'backend_name', $this->backend_name])
            ->andFilterWhere(['like', 'frontend_name', $this->frontend_name]);

        return $dataProvider;
    }
}
