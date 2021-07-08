<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "megaindex_account".
 *
 * @property int $id
 * @property string|null $login
 * @property string|null $password
 * @property int|null $proxy_id
 * @property int|null $useragent_id
 */
class MegaindexAccount extends \yii\db\ActiveRecord
{
    public $list;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'megaindex_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proxy_id', 'useragent_id'], 'integer'],
            [['login', 'password'], 'string', 'max' => 255],
            [['login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'proxy_id' => 'Прокси ID',
            'useragent_id' => 'Юзерагент ID',
        ];
    }

    public function getProxy()
    {
        return $this->hasOne(Proxy::className(), ['id' => 'proxy_id']);
    }

    public function getUseragent()
    {
        return $this->hasOne(Useragent::className(), ['id' => 'useragent_id']);
    }

    public function beforeSave($insert)
    {
        $busyProxyIds = [];
        $busyUseragentIds = [];
        $accounts = MegaindexAccount::find()->asArray()->all();
        if ($accounts) {
            $busyProxyIds = ArrayHelper::getColumn($accounts, 'proxy_id');
            $busyUseragentIds = ArrayHelper::getColumn($accounts, 'useragent_id');
        }

        $proxyIds = ArrayHelper::getColumn(Proxy::find()->asArray()->all(), 'id');
        foreach ($proxyIds as $k => $proxyId) {
            if (ArrayHelper::isIn($proxyId, $busyProxyIds)) {
                unset($proxyIds[$k]);
            }
        }

        $useragentIds = ArrayHelper::getColumn(Useragent::find()->asArray()->all(), 'id');
        foreach ($useragentIds as $k => $useragentId) {
            if (ArrayHelper::isIn($useragentId, $busyUseragentIds)) {
                unset($useragentIds[$k]);
            }
        }

        $freeProxyId = array_shift($proxyIds);
        $freeUseragentId = array_shift($useragentIds);

        $this->proxy_id = $freeProxyId;
        $this->useragent_id = $freeUseragentId;

        return parent::beforeSave($insert);
    }
}
