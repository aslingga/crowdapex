<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Oadode;

/**
 * OadodeSearch represents the model behind the search form of `common\models\Oadode`.
 */
class OadodeSearch extends Oadode
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'application_id', 'customer_id', 'user_id', 'application_type', 'lang'], 'integer'],
            [['legal_name', 'business_name', 'business_address', 'business_mailing_address', 'business_phone', 'business_fax', 'business_email', 'business_title'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Oadode::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'application_id' => $this->application_id,
            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id,
            'application_type' => $this->application_type,
            'lang' => $this->lang,
        ]);

        $query->andFilterWhere(['like', 'legal_name', $this->legal_name])
            ->andFilterWhere(['like', 'business_name', $this->business_name])
            ->andFilterWhere(['like', 'business_address', $this->business_address])
            ->andFilterWhere(['like', 'business_mailing_address', $this->business_mailing_address])
            ->andFilterWhere(['like', 'business_phone', $this->business_phone])
            ->andFilterWhere(['like', 'business_fax', $this->business_fax])
            ->andFilterWhere(['like', 'business_email', $this->business_email])
            ->andFilterWhere(['like', 'business_title', $this->business_title]);

        return $dataProvider;
    }
}
