<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sale;

/**
 * SaleSearch represents the model behind the search form of `app\models\Sale`.
 */
class SaleSearch extends Sale
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uploaded_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'contact'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Sale::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uploaded_by' => $this->uploaded_by,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'contact', $this->contact]);

        return $dataProvider;
    }
}
