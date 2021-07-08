<?php

namespace common\components;

use common\components\Proxy\ProxyManager;
use common\models\Proxy;
use common\models\Setting;
use common\models\Useragent;
use Curl\Curl;
use Curl\MultiCurl;

class Parser
{
    private $proxySettings = [];
    private $useragentList = [];
    private $multiCurl;
    private $data;
    private $urls = [];
    private $dataCurls = [];
    private $failedUrls = [];
    private $proxies = [];
    public $proxyProtocol = Proxy::PROTOCOL_IPv4;

    public function __construct()
    {
        $multiCurl = new MultiCurl();
        $multiCurl->success(function ($instance) {
            $this->curlSuccess($instance);
        });
        $multiCurl->error(function ($instance) {
            $this->curlError($instance);
        });
        $multiCurl->complete(function ($instance) {
            $this->curlComplete($instance);
        });
        $this->multiCurl = $multiCurl;
    }

    public function start()
    {
        $this->loadConfig();

        $i = 0;
        while ($this->hasUrls() && $i < Setting::getParserSettings()['tryLimit']) {
            $this->failedUrls = [];
            $this->dataCurls = [];
            foreach ($this->urls as $url) {
                $this->createCurl($url, $this->getRandomProxy());
            }
            foreach ($this->dataCurls as $dataCurl) {
                $this->addCurl($dataCurl['curl']);
            }
            $this->multiCurl->start();;
            $this->urls = $this->failedUrls;
            $i++;
        }
    }

    private function loadConfig()
    {
        $proxyManager = new ProxyManager($this->proxyProtocol);
        $this->proxySettings = $proxyManager->getSettings();
        if ($this->proxySettings['enabled']) {
            $this->proxies = $proxyManager->getProxy();
            if (!$this->proxies) {
                die('no proxy');
            }
        }
        $this->loadUseragentList();
    }

    private function createCurl($url, $proxy = NULL)
    {
        $dataCurl = [];
        $curl = new Curl();
        $curl->setUrl($url);
        $curl->setUserAgent($this->getRandomUseragent());
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, 0);
        $curl->setOpt(CURLOPT_CUSTOMREQUEST, 'GET');
        $curl->setOpt(CURLOPT_HTTPGET, true);
        $curl->setOpt(CURLOPT_FRESH_CONNECT, 1);

        if (is_array($proxy)) {
            $curl->setProxy($proxy['ip'], $proxy['port'], $proxy['login'], $proxy['password']);
            $curl->setOpt(CURLOPT_PROXYAUTH, CURLAUTH_ANY);
            $curl->setProxyType(Proxy::TYPES[$proxy['type']]);
            if ($proxy['protocol'] == Proxy::PROTOCOL_IPv6) {
                $curl->setOpt(CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6);
            }
            $curl->setOpt(CURLOPT_TIMEOUT, $this->proxySettings['timeout']);
            $dataCurl['proxy'] = $proxy['ip'] . ':' . $proxy['port'];
        }

        $dataCurl['curl'] = $curl;
        $dataCurl['url'] = $url;

        $this->dataCurls[] = $dataCurl;
    }

    private function addCurl(Curl $curl)
    {
        $this->multiCurl->addCurl($curl);
    }

    public function addUrls($urls = [])
    {
        if (empty($urls)) {
            return false;
        }

        foreach ($urls as $url) {
            $this->urls[] = $url;
        }

        return true;
    }

    private function getRandomProxy()
    {
        if (empty($this->proxies)) {
            return false;
        }

        return $this->proxies[rand(0, count($this->proxies) - 1)];
    }

    private function loadUseragentList()
    {
        $list = Useragent::find()->asArray()->all();
        foreach ($list as $item) {
            $this->useragentList[] = $item['useragent'];
        }
    }

    private function getRandomUseragent()
    {
        if (empty($this->useragentList)) {
            return '';
        }

        return $this->useragentList[rand(0, count($this->useragentList) - 1)];
    }

    public function setJsonDecoder($mixed)
    {
        $this->multiCurl->setJsonDecoder($mixed);
    }

    public function removeFromFailedUrls($url)
    {
        foreach ($this->failedUrls as $k => $failedUrl) {
            if (trim($failedUrl) == trim($url)) {
                unset($this->failedUrls[$k]);
            }
        }
    }

    public function addFailedUrls($url)
    {
        $isNeeded = true;
        foreach ($this->failedUrls as $k => $failedUrl) {
            if (trim($failedUrl) == trim($url)) {
                $isNeeded = false;
            }
        }
        if ($isNeeded) {
            $this->failedUrls[] = $url;
            return true;
        }

        return false;
    }

    public function hasUrls()
    {
        return count($this->urls) > 0;
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

    public function curlSuccess($instance)
    {
        $this->data[] = ['url' => $instance->url, 'response' => $instance->response];
        $this->removeFromFailedUrls($instance->url);
    }

    public function curlError($instance)
    {
        if ($instance->errorCode === 404) {
            $this->data[] = ['url' => $instance->url, 'response' => 404];
            $this->removeFromFailedUrls($instance->url);
            return;
        } else if ($instance->errorCode === 502) {
            $this->data[] = ['url' => $instance->url, 'response' => 502];
            $this->removeFromFailedUrls($instance->url);
            return;
        } else if ($instance->errorCode != 200) {
            if (!$this->proxySettings['api.enabled']) {
                Proxy::updateErrorsCounterByProxy($this->findProxyByUrl($instance->url));
            }
            $this->addFailedUrls($instance->url);
            return;
        }
    }

    public function curlComplete($instance)
    {
    }
    
    private function findProxyByUrl($url)
    {
        foreach ($this->dataCurls as $k => $dataCurl) {
            if (trim($this->dataCurls[$k]['url']) == trim($url)) {
                return $this->dataCurls[$k]['proxy'];
            }
        }

        return false;
    }

    public function setHeaders(array $headers)
    {
        $this->multiCurl->setHeaders($headers);
    }
}