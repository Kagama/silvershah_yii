<?php

namespace common\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\ProductComment;

/**
 * ProductCommentSearch represents the model behind the search form about `common\modules\catalog\models\ProductComment`.
 */
class ProductCommentSearch extends ProductComment
{
    public function rules()
    {
        return [
            [['id', 'owner_id', 'date', 'like_count', 'unlike_count', 'product_id', 'approve', 'level', 'rate'], 'integer'],
            [['email', 'username', 'text'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductComment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'date' => $this->date,
            'like_count' => $this->like_count,
            'unlike_count' => $this->unlike_count,
            'product_id' => $this->product_id,
            'approve' => $this->approve,
            'level' => $this->level,
            'rate' => $this->rate,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
