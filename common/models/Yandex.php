<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yandex".
 *
 * @property int $id
 * @property int|null $domain_id
 * @property int|null $sqi
 * @property int|null $is_completed_sqi
 *
 * @property Domain $domain
 * @property string|null $domainName
 */
class Yandex extends \yii\db\ActiveRecord
{
    const SQI_STATUS_COMPLETED = 1;
    const SQI_STATUS_FAILED = 0;

    public $domainName;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yandex';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain_id', 'sqi', 'is_completed_sqi'], 'integer'],
            [['domain_id'], 'unique'],
            [['domain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Domain::className(), 'targetAttribute' => ['domain_id' => 'id']],
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
            'sqi' => 'ИКС',
            'is_completed_sqi' => 'ИКС проверен',
        ];
    }

    /**
     * Gets query for [[Domain]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDomain()
    {
        return $this->hasOne(Domain::className(), ['id' => 'domain_id']);
    }
}
