<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "proxy".
 *
 * @property int $id
 * @property string $ip
 * @property string $port
 * @property string $type
 * @property string|null $protocol
 * @property string|null $login
 * @property string|null $password
 * @property int|null $totalTime
 * @property int|null $connectTime
 * @property int|null $pretransferTime
 * @property int|null $countCaptcha
 * @property int|null $countErrors
 * @property int|null $redirected
 * @property int|null $status
 */
class Proxy extends \yii\db\ActiveRecord
{
    public $list;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 1;

    const PROXY_SOCKS4 = 'socks4';
    const PROXY_SOCKS5 = 'socks5';
    const PROXY_HTTPS = 'https';
    const TYPES = [
        self::PROXY_SOCKS4 => CURLPROXY_SOCKS4,
        self::PROXY_SOCKS5 => 7,
        self::PROXY_HTTPS => 2,
    ];

    const PROTOCOL_IPv6 = 'ipv6';
    const PROTOCOL_IPv4 = 'ipv4';
    const PROTOCOLS = [self::PROTOCOL_IPv4, self::PROTOCOL_IPv6];

    const DEFAULT_SATS = [
        'totalTime' => 0,
        'connectTime' => 0,
        'pretransferTime' => 0,
        'countCaptcha' => 0,
        'countErrors' => 0,
        'redirected' => 0,
        'status' => 1,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proxy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip', 'port', 'type'], 'required'],
            [['totalTime', 'connectTime', 'pretransferTime', 'countCaptcha', 'countErrors', 'redirected', 'status'], 'integer'],
            [['ip', 'port', 'type', 'login', 'password'], 'string', 'max' => 255],
            [['protocol'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'port' => 'Port',
            'type' => 'Type',
            'protocol' => 'Protocol',
            'login' => 'Login',
            'password' => 'Password',
            'totalTime' => 'Total Time',
            'connectTime' => 'Connect Time',
            'pretransferTime' => 'Pretransfer Time',
            'countCaptcha' => 'Count Captcha',
            'countErrors' => 'Count Errors',
            'redirected' => 'Redirected',
            'status' => 'Status',
        ];
    }

    public static function setRedirectedStatusProxy($proxy)
    {
        $model = self::selectProxy($proxy);
        $model->redirected = 1;
        $model->status = 0;

        return $model->save();
    }

    public static function updateErrorsCounterByProxy($proxy)
    {
        $model = self::selectProxy($proxy);
        $model->updateCounters(['countErrors' => 1]);
    }

    public static function selectProxy($proxy) {
        if (!$proxy) {
            return false;
        }
        $parts = explode(':', $proxy);
        $ip = $parts[0];
        $port = $parts[1];
        $model = Proxy::find()->where(['ip' => $ip])->andWhere(['port' => $port])->one();
        if (!$model) {
            return false;
        }

        return $model;
    }

    public static function getActiveProxyAsArray($protocol)
    {
        return Proxy::find()
            ->where(['status' => 1])
            ->andWhere(['<=', 'connectTime',  Setting::getProxySettings()['ping']])
            ->andWhere(['protocol' => $protocol])
            ->asArray()
            ->all();
    }
}
