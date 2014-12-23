<?php

namespace common\modules\order\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\order\models\Order;

/**
 * OrderSearch represents the model behind the search form about `common\modules\order\models\Order`.
 */
class OrderSearch extends Order
{
    public function rules()
    {
        return [
            [['id', 'status', 'date'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'date' => $this->date,
        ]);

        return $dataProvider;
    }
}
