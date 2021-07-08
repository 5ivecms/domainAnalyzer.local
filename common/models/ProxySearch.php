<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Proxy;

/**
 * ProxySearch represents the model behind the search form of `common\models\Proxy`.
 */
class ProxySearch extends Proxy
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'totalTime', 'connectTime', 'pretransferTime', 'countCaptcha', 'countErrors', 'redirected', 'status'], 'integer'],
            [['ip', 'port', 'type', 'protocol', 'login', 'password'], 'safe'],
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
        $query = Proxy::find();

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
            'totalTime' => $this->totalTime,
            'connectTime' => $this->connectTime,
            'pretransferTime' => $this->pretransferTime,
            'countCaptcha' => $this->countCaptcha,
            'countErrors' => $this->countErrors,
            'redirected' => $this->redirected,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'port', $this->port])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'protocol', $this->protocol])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
}
