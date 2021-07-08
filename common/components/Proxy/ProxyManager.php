<?php

namespace common\components\Proxy;

use common\components\Proxy\Services\BestProxiesRu;
use common\components\Proxy\Services\Proxy6Net;
use common\models\Proxy;
use common\models\Setting;

class ProxyManager
{
    private $settings;
    private $proxy;
    private $protocol;

    public function __construct($protocol = Proxy::PROTOCOL_IPv4)
    {
        $this->protocol = $protocol;
        $this->loadSettings();
        $this->loadProxy();
    }

    public function getProxy()
    {
        if (!$this->proxy) {
            return [];
        }

        return $this->proxy;
    }

    public function getSettings()
    {
        return $this->settings;
    }

    private function loadSettings()
    {
        $this->settings = Setting::getGroupSettings('proxy', false);
    }

    private function loadProxy()
    {
        if ($this->settings['api.enabled'] && !empty($this->settings['api.name']) && !empty($this->settings['api.url'])) {
            $proxy = [];
            switch ($this->settings['api.name']) {
                case APIServices::PROXY6_NET:
                    $proxy = Proxy6Net::getProxy($this->settings['api.url']);
                    break;
                case APIServices::BEST_PROXIES_RU:
                    $proxy = BestProxiesRu::getProxy($this->settings['api.url']);
                    break;
            }
            $this->proxy = $proxy;
        } else {
            $this->proxy = Proxy::getActiveProxyAsArray($this->protocol);
        }
    }
}