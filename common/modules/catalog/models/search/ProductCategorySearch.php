<?php

namespace common\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\ProductCategory;

/**
 * ProductCategorySearch represents the model behind the search form about `common\modules\catalog\models\ProductCategory`.
 */
class ProductCategorySearch extends ProductCategory
{
    public function rules()
    {
        return [
            [['id', 'parent_id', 'level', 'position'], 'integer'],
            [['name', 'alt_name', 'img', 'src', 'text_before', 'text_after', 'seo_title', 'seo_keywords', 'seo_description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
            'position' => $this->position,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alt_name', $this->alt_name])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'src', $this->src])
            ->andFilterWhere(['like', 'text_before', $this->text_before])
            ->andFilterWhere(['like', 'text_after', $this->text_after])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description]);

        return $dataProvider;
    }
}
