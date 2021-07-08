<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linkpad".
 *
 * @property int $id
 * @property int $domain_id
 * @property int|null $linkpad_rank
 * @property int|null $backlinks
 * @property int|null $nofollow_links
 * @property int|null $no_anchor_links
 * @property int|null $count_ips
 * @property int|null $count_subnet
 * @property int|null $referring_domains
 * @property float|null $domain_links_ru
 * @property float|null $domain_links_rf
 * @property float|null $domain_links_com
 * @property float|null $domain_links_su
 * @property float|null $domain_links_other
 * @property int|null $is_completed
 */
class Linkpad extends \yii\db\ActiveRecord
{
    const STATUS_COMPLETED = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linkpad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain_id'], 'required'],
            [['domain_id'], 'unique'],
            [['domain_id', 'linkpad_rank', 'backlinks', 'nofollow_links', 'no_anchor_links', 'count_ips', 'count_subnet', 'referring_domains', 'is_completed'], 'integer'],
            [['domain_links_ru', 'domain_links_rf', 'domain_links_com', 'domain_links_su', 'domain_links_other'], 'safe'],
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
            'linkpad_rank' => 'Linkpad Rank',
            'backlinks' => 'Backlinks',
            'nofollow_links' => 'Nofollow Links',
            'no_anchor_links' => 'No Anchor Links',
            'count_ips' => 'Count Ips',
            'count_subnet' => 'Count Subnet',
            'referring_domains' => 'Referring Domains',
            'domain_links_ru' => 'Ссылки RU',
            'is_completed' => 'Завершено',
        ];
    }
}
