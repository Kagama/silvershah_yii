<?php

namespace common\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\ProductPromotion;

/**
 * ProductPromotionSearch represents the model behind the search form about `common\modules\catalog\models\ProductPromotion`.
 */
class ProductPromotionSearch extends ProductPromotion
{
    public function rules()
    {
        return [
            [['id', 'position', 'active'], 'integer'],
            [['name', 'alt_name'], 'safe'],
            [['discount'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductPromotion::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'position' => $this->position,
            'active' => $this->active,
            'discount' => $this->discount,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alt_name', $this->alt_name]);

        return $dataProvider;
    }
}
