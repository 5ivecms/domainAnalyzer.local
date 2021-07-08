<?php

namespace backend\components;

use common\models\Proxy;
use common\models\Setting;
use Curl\MultiCurl;

class Parser
{
    const PROXY_TYPES = [
        //'https'  => CURLPROXY_HTTPS,
        'http'   => CURLPROXY_HTTP,
        'socks4' => CURLPROXY_SOCKS4,
        'socks5' => CURLPROXY_SOCKS5,
    ];

    private $parserSettings = [];
    private $proxySettings = [];

    private $curl;
    private $data;
    private $failedUrls = [];
    private $proxies = [];
    private $forceUsingProxy;

    public function __construct($forceUsingProxy = true)
    {
        $curl = new MultiCurl();
        $curl->success(function($instance) {
            $this->curlSuccess($instance);
        });
        $curl->error(function($instance) {
            $this->curlError($instance);
        });
        $curl->complete(function($instance) {
            $this->curlComplete($instance);
        });
        $this->forceUsingProxy = $forceUsingProxy;
        $this->curl = $curl;
        $this->setConfig();
    }

    private function setConfig()
    {
        $this->parserSettings = Setting::getGroupSettings('parser', false);
        $this->proxySettings = Setting::getGroupSettings('proxy', false);
        if ($this->forceUsingProxy && $this->proxySettings['enabled']) {
            $this->proxies = Proxy::getFromUrl($this->proxySettings['url']);
            $this->setTimeout($this->proxySettings['timeout']);
            $this->setProxies($this->proxies, $this->proxySettings['type']);
        }
        $this->setUserAgent($this->parserSettings['useragentList']);
        $this->setSettings([
            CURLOPT_SSL_VERIFYPEER => false
        ]);
    }

    public function start()
    {
        $tryLimit = 20;
        for ($i = 0; $i < $tryLimit; $i++) {
            $this->curl->start();
            if ($this->hasFailedUrls()) {
                if ($this->forceUsingProxy && $this->proxySettings['enabled']) {
                    $this->curl->unsetProxy();
                    $this->setProxies($this->proxies, $this->proxySettings['type']);
                }
                $this->addUrls($this->failedUrls);
            } else {
                break;
            }
        }
    }

    private function curlSuccess($instance)
    {
        $this->data[] = ['url' => $instance->url, 'response' => $instance->response];
        $this->removeFromFailedUrls($instance->url);
        //echo 'call to "' . $instance->url . '" was successful.' . "\n";
        //echo 'response:' . "\n";
        //var_dump($instance->response);
    }

    private function curlError($instance)
    {
        if ($instance->errorCode === 404) {
            $this->data[] = ['url' => $instance->url, 'response' => 404];
            $this->removeFromFailedUrls($instance->url);
            return;
        }
        if ($instance->errorCode != 400) {
            $this->failedUrls[] = $instance->url;
        }
        /*if (isset($instance->response->error)) {
            echo 'call to "' . $instance->url . '" was unsuccessful.' . "\n" . '<br>';
            echo 'error code: ' . $instance->errorCode . "\n" . '<br>';
            echo 'error message: ' . $instance->errorMessage . "\n";
            echo '<br><br>Ответ:<br>';
        }*/

        /*echo 'call to "' . $instance->url . '" was unsuccessful.' . "\n";
        echo 'error code: ' . $instance->errorCode . "\n";
        echo 'error message: ' . $instance->errorMessage . "\n";
        echo '<br><br>';*/
    }

    private function curlComplete($instance)
    {
        //echo 'call completed' . "\n";
    }

    public function setSettings(array $settings = [])
    {
        foreach ($settings as $option => $value) {
            $this->curl->setOpt($option, $value);
        }
    }

    public function setTimeout($seconds = 7)
    {
        $this->curl->setTimeout($seconds);
    }

    public function setHeaders(array $headers)
    {
        $this->curl->setHeaders($headers);
    }

    public function setUserAgent($userAgentList)
    {
        $userAgents = explode("\n", $userAgentList);
        $userAgent = $userAgents[rand(0, count($userAgents) - 1)];
        $this->curl->setUserAgent($userAgent);
    }

    public function setProxies(array $proxies = [], $type = 'socks4')
    {
        $this->curl->setProxies($proxies);
        $this->curl->setProxyType(Parser::PROXY_TYPES[$type]);
    }

    public function addUrls(array $urls)
    {
        foreach ($urls as $url) {
            $this->curl->addGet($url, []);
        }
    }

    public function removeFromFailedUrls($url)
    {
        foreach ($this->failedUrls as $k => $failedUrl) {
            if (trim($failedUrl) == trim($url)) {
                unset($this->failedUrls[$k]);
            }
        }
    }

    public function hasFailedUrls()
    {
        return count($this->failedUrls) > 0;
    }

    public function getFailedUrls()
    {
        return $this->failedUrls;
    }

    public function getData()
    {
        return $this->data;
    }

    public function clearData()
    {
        $this->data = [];
    }

    public function clearFailedUrls()
    {
        $this->failedUrls = [];
    }
}