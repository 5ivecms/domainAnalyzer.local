<?php


namespace common\components\Proxy\Services;


use common\components\Proxy\APIServices;
use common\models\Proxy;
use Yii;

class BestProxiesRu
{
    public static function getProxy($url)
    {
        if (empty($url)) {
            return false;
        }

        $proxies = Yii::$app->cache->get('proxy.' . APIServices::BEST_PROXIES_RU . '.list');
        if ($proxies) {
            return $proxies;
        }

        try {
            $result = file_get_contents($url);
        } catch (\Exception $e) {
            return false;
        }

        $result = json_decode($result);

        $proxies = [];
        foreach ($result as $item) {
            $proxy = [];
            $proxy['ip'] = $item->ip;
            $proxy['port'] = $item->port;
            $proxy['type'] = self::getProxyType($item);
            $proxy['protocol'] = Proxy::PROTOCOL_IPv4;
            $proxy['login'] = NULL;
            $proxy['password'] = NULL;
            $proxies[] = $proxy;
        }

        Yii::$app->cache->set('proxy.' . APIServices::BEST_PROXIES_RU . '.list', $proxies, 60);

        return $proxies;
    }

    protected static function getProxyType($proxy)
    {
        if ($proxy->https) {
            return Proxy::PROXY_HTTPS;
        }
        if ($proxy->socks4) {
            return Proxy::PROXY_SOCKS4;
        }
        if ($proxy->socks5) {
            return Proxy::PROXY_SOCKS5;
        }
    }
}