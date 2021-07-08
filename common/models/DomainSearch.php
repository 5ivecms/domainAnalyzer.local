<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DomainSearch represents the model behind the search form of `common\models\Domain`.
 */
class DomainSearch extends Domain
{
    public $linkpad_rank;
    public $linkpad_backlinks;
    public $linkpad_nofollow_links;
    public $linkpad_no_anchor_links;
    public $linkpad_count_ips;
    public $linkpad_count_subnet;
    public $linkpad_referring_domains;
    public $linkpad_domain_links_ru;
    public $linkpad_domain_links_rf;
    public $linkpad_domain_links_com;
    public $linkpad_domain_links_su;
    public $linkpad_domain_links_other;

    public $megaindex_total_self_uniq_links;
    public $megaindex_total_anchors_unique;
    public $megaindex_total_self_domains;
    public $megaindex_trust_rank;
    public $megaindex_domain_rank;
    public $megaindex_organic_traffic;
    public $megaindex_increasing_search_traffic;
    public $megaindex_popular_keywords;

    public $yandex_sqi;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'is_available'], 'integer'],
            [['domain', 'linkpad_rank', 'linkpad_backlinks', 'linkpad_nofollow_links', 'linkpad_no_anchor_links',
                'linkpad_count_ips', 'linkpad_count_subnet', 'linkpad_referring_domains', 'linkpad_domain_links_ru',
                'linkpad_domain_links_rf', 'linkpad_domain_links_com', 'linkpad_domain_links_su', 'linkpad_domain_links_other',
                'megaindex_total_self_uniq_links', 'megaindex_total_anchors_unique', 'megaindex_total_self_domains',
                'megaindex_trust_rank', 'megaindex_domain_rank', 'megaindex_organic_traffic', 'megaindex_increasing_search_traffic', 'megaindex_popular_keywords', 'yandex_sqi'
            ], 'safe'],
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
        $query = Domain::find()->joinWith('linkpad')->joinWith('megaindex')->joinWith('yandex');

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

        $dataProvider->setSort([
            'attributes' => array_merge($dataProvider->getSort()->attributes, [
                // Linkpad
                'linkpad_rank' => [
                    'asc' => [Linkpad::tableName() . '.linkpad_rank' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.linkpad_rank' => SORT_DESC]
                ],
                'linkpad_backlinks' => [
                    'asc' => [Linkpad::tableName() . '.backlinks' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.backlinks' => SORT_DESC]
                ],
                'linkpad_nofollow_links' => [
                    'asc' => [Linkpad::tableName() . '.nofollow_links' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.nofollow_links' => SORT_DESC]
                ],
                'linkpad_no_anchor_links' => [
                    'asc' => [Linkpad::tableName() . '.no_anchor_links' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.no_anchor_links' => SORT_DESC]
                ],
                'linkpad_count_ips' => [
                    'asc' => [Linkpad::tableName() . '.count_ips' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.count_ips' => SORT_DESC]
                ],
                'linkpad_count_subnet' => [
                    'asc' => [Linkpad::tableName() . '.count_subnet' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.count_subnet' => SORT_DESC]
                ],
                'linkpad_referring_domains' => [
                    'asc' => [Linkpad::tableName() . '.referring_domains' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.referring_domains' => SORT_DESC]
                ],
                'linkpad_domain_links_ru' => [
                    'asc' => [Linkpad::tableName() . '.domain_links_ru' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.domain_links_ru' => SORT_DESC]
                ],
                'linkpad_domain_links_rf' => [
                    'asc' => [Linkpad::tableName() . '.domain_links_rf' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.domain_links_rf' => SORT_DESC]
                ],
                'linkpad_domain_links_com' => [
                    'asc' => [Linkpad::tableName() . '.domain_links_com' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.domain_links_com' => SORT_DESC]
                ],
                'linkpad_domain_links_su' => [
                    'asc' => [Linkpad::tableName() . '.domain_links_su' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.domain_links_su' => SORT_DESC]
                ],
                'linkpad_domain_links_other' => [
                    'asc' => [Linkpad::tableName() . '.domain_links_other' => SORT_ASC],
                    'desc' => [Linkpad::tableName() . '.domain_links_other' => SORT_DESC]
                ],

                // Megaindex
                'megaindex_total_self_uniq_links' => [
                    'asc' => [Megaindex::tableName() . '.total_self_uniq_links' => SORT_ASC],
                    'desc' => [Megaindex::tableName() . '.total_self_uniq_links' => SORT_DESC]
                ],
                'megaindex_total_anchors_unique' => [
                    'asc' => [Megaindex::tableName() . '.total_anchors_unique' => SORT_ASC],
                    'desc' => [Megaindex::tableName() . '.total_anchors_unique' => SORT_DESC]
                ],
                'megaindex_total_self_domains' => [
                    'asc' => [Megaindex::tableName() . '.total_self_domains' => SORT_ASC],
                    'desc' => [Megaindex::tableName() . '.total_self_domains' => SORT_DESC]
                ],
                'megaindex_trust_rank' => [
                    'asc' => [Megaindex::tableName() . '.trust_rank' => SORT_ASC],
                    'desc' => [Megaindex::tableName() . '.trust_rank' => SORT_DESC]
                ],
                'megaindex_domain_rank' => [
                    'asc' => [Megaindex::tableName() . '.domain_rank' => SORT_ASC],
                    'desc' => [Megaindex::tableName() . '.domain_rank' => SORT_DESC]
                ],
                'megaindex_organic_traffic' => [
                    'asc' => [Megaindex::tableName() . '.organic_traffic' => SORT_ASC],
                    'desc' => [Megaindex::tableName() . '.organic_traffic' => SORT_DESC]
                ],
                'megaindex_increasing_search_traffic' => [
                    'asc' => [Megaindex::tableName() . '.increasing_search_traffic' => SORT_ASC],
                    'desc' => [Megaindex::tableName() . '.increasing_search_traffic' => SORT_DESC]
                ],
                'megaindex_popular_keywords' => [
                    'asc' => [Megaindex::tableName() . '.popular_keywords' => SORT_ASC],
                    'desc' => [Megaindex::tableName() . '.popular_keywords' => SORT_DESC]
                ],

                // Yandex
                'yandex_sqi' => [
                    'asc' => [Yandex::tableName() . '.sqi' => SORT_ASC],
                    'desc' => [Yandex::tableName() . '.sqi' => SORT_DESC]
                ],
            ])
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'is_available' => $this->is_available,
            Linkpad::tableName() . '.linkpad_rank' => $this->linkpad_rank,
            Linkpad::tableName() . '.backlinks' => $this->linkpad_backlinks,
            Linkpad::tableName() . '.nofollow_links' => $this->linkpad_backlinks,
            Linkpad::tableName() . '.no_anchor_links' => $this->linkpad_no_anchor_links,
            Linkpad::tableName() . '.count_ips' => $this->linkpad_count_ips,
            Linkpad::tableName() . '.count_ips' => $this->linkpad_referring_domains,
            Linkpad::tableName() . '.domain_links_ru' => $this->linkpad_domain_links_ru,
            Linkpad::tableName() . '.domain_links_rf' => $this->linkpad_domain_links_rf,
            Linkpad::tableName() . '.domain_links_com' => $this->linkpad_domain_links_com,
            Linkpad::tableName() . '.domain_links_su' => $this->linkpad_domain_links_su,
            Linkpad::tableName() . '.domain_links_other' => $this->linkpad_domain_links_other,
            Megaindex::tableName() . '.total_self_uniq_links' => $this->megaindex_total_self_uniq_links,
            Megaindex::tableName() . '.total_anchors_unique' => $this->megaindex_total_anchors_unique,
            Megaindex::tableName() . '.total_self_domains' => $this->megaindex_total_self_domains,
            Megaindex::tableName() . '.trust_rank' => $this->megaindex_trust_rank,
            Megaindex::tableName() . '.domain_rank' => $this->megaindex_domain_rank,
            Megaindex::tableName() . '.organic_traffic' => $this->megaindex_organic_traffic,
            Megaindex::tableName() . '.increasing_search_traffic' => $this->megaindex_increasing_search_traffic,
            Megaindex::tableName() . '.popular_keywords' => $this->megaindex_popular_keywords,
            Yandex::tableName() . '.sqi' => $this->yandex_sqi,
        ]);

        $query->andFilterWhere(['like', 'domain', $this->domain]);

        return $dataProvider;
    }
}
