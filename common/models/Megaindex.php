<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "megaindex".
 *
 * @property int $id
 * @property int $domain_id
 * @property int|null $total_self_uniq_links
 * @property int|null $total_anchors_unique
 * @property int|null $total_self_domains
 * @property int|null $trust_rank
 * @property int|null $domain_rank
 * @property int|null $organic_traffic
 * @property int|null $increasing_search_traffic
 * @property int|null $popular_keywords
 * @property int|null $is_completed
 */
class Megaindex extends \yii\db\ActiveRecord
{
    const STATUS_COMPLETED = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'megaindex';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain_id'], 'required'],
            [['domain_id', 'total_self_uniq_links', 'total_anchors_unique', 'total_self_domains', 'trust_rank', 'domain_rank', 'is_completed', 'organic_traffic', 'increasing_search_traffic', 'popular_keywords'], 'integer'],
            [['domain_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain_id' => 'Domain ID',
            'total_self_uniq_links' => 'MI домены',
            'total_anchors_unique' => 'MI анкоры',
            'total_self_domains' => 'MI ссылки',
            'trust_rank' => 'MI Trust Rank',
            'domain_rank' => 'MI Domain Rank',
            'organic_traffic' => 'MI Organic',
            'increasing_search_traffic' => 'MI Increasing Organic (%)',
            'popular_keywords' => 'MI Popular Keywords',
            'is_completed' => 'Завершено',
        ];
    }
}
