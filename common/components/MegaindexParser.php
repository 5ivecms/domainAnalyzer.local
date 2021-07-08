<?php

namespace common\components;

use common\models\Domain;
use common\models\Megaindex;
use common\models\MegaindexAccount;
use common\models\Setting;
use common\models\Tools;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Yii;

class MegaindexParser
{
    static $host = 'http://localhost:4444/wd/hub';
    static $authUrl = 'https://ru.megaindex.com/auth';
    static $logoutUrl = 'https://ru.megaindex.com/auth/logout';
    static $backlinksUrl = 'https://ru.megaindex.com/backlinks/';
    static $trafficUrl = 'https://ru.megaindex.com/info/';

    private $domains = [];
    private $domainsPerAccount = 4;
    private $config;

    public $isAuth = false;
    public $accounts;
    public $currentAccount;
    public $cookieFile;

    public $driver;

    public function parser()
    {
        Tools::removeTimeout();
        $this->setConfig();
        $this->setAccounts();

        $chunks = array_chunk($this->domains, $this->domainsPerAccount);
        if (!$this->createDriver()) {
            return false;
        }

        foreach ($chunks as $domains) {
            $this->setCurrentAccount();
            if (!$this->auth()) {
                $this->quit();
                return false;
            }

            foreach ($domains as $domain) {
                $backlinksStatistic = $this->getBacklinksStatistic($domain['domain']);
                if (!$backlinksStatistic) {
                    continue;
                }

                $trafficStatistic = $this->getTrafficStatistic($domain['domain']);
                if (!$trafficStatistic) {
                    continue;
                }

                $statistic['domain'] = $domain['domain'];
                $statistic = array_merge($statistic, $backlinksStatistic, $trafficStatistic);

                $this->updateDomain($statistic);
            }

            if (!$this->logout()) {
                $this->quit();
                return false;
            }
        }

        $this->quit();

        return true;
    }

    private function quit()
    {
        $this->isAuth = false;
        $this->driver->close();
        $this->driver->quit();
        Tools::killChromedriverProcess();
    }

    private function createDriver()
    {
        $options = new ChromeOptions();
        $options->addArguments(["--headless"]);
        $options->addArguments(['--window-size=1368,768']);
        $options->addArguments(['--enable-file-cookies']);
        if ($this->config['proxy.enabled']) {
            $options->addArguments(['--proxy-server=socks5://' . $this->currentAccount->proxy->ip . ':' . $this->currentAccount->proxy->ip]);
        }
        $caps = DesiredCapabilities::chrome();
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);

        try {
            $this->driver = RemoteWebDriver::create(self::$host, $caps, 120 * 1000, 120 * 1000);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    private function auth($forcedAuth = false)
    {
        if (!$this->isAuth || $forcedAuth) {
            try {
                $this->driver->get(self::$authUrl);
            } catch (\Exception $e) {
                return false;
            }

            $this->driver->findElement(WebDriverBy::name('email'))->sendKeys($this->currentAccount->login);
            $this->driver->findElement(WebDriverBy::name('password'))->sendKeys($this->currentAccount->password)->submit();
            sleep(1);
            $cookies = $this->driver->manage()->getCookies();
            foreach ($cookies as $cookie) {
                $this->driver->manage()->addCookie($cookie);
            }
            file_put_contents($this->cookieFile, serialize($cookies));
            $this->isAuth = true;
        }

        return true;
    }

    private function logout()
    {
        try {
            $this->driver->get(self::$logoutUrl);
            $this->isAuth = false;
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    private function getBacklinksStatistic($domain)
    {
        $this->driver->get(self::$backlinksUrl . $domain);
        try {
            $this->driver->wait()->until(
                WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::cssSelector('#total_self_uniq_links img'))
            );
        } catch (\Exception $e) {
            return false;
        }
        try {
            $this->driver->wait()->until(
                WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::cssSelector('#total_anchors_unique img'))
            );
        } catch (\Exception $e) {
            return false;
        }
        try {
            $this->driver->wait()->until(
                WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::cssSelector('#total_self_domains img'))
            );
        } catch (\Exception $e) {
            return false;
        }

        try {
            $total_self_uniq_links = $this->driver->findElement(WebDriverBy::id('total_self_uniq_links'))->getText();
        } catch (\Exception $e) {
            $total_self_uniq_links = 0;
        }
        try {
            $total_anchors_unique = $this->driver->findElement(WebDriverBy::id('total_anchors_unique'))->getText();
        } catch (\Exception $e) {
            $total_anchors_unique = 0;
        }
        try {
            $total_self_domains = $this->driver->findElement(WebDriverBy::id('total_self_domains'))->getText();
        } catch (\Exception $e) {
            $total_self_domains = 0;
        }
        try {
            $trust_rank = $this->driver->findElement(WebDriverBy::cssSelector('#ctr svg .drchart-text'))->getText();
        } catch (\Exception $e) {
            $trust_rank = 0;
        }
        try {
            $domain_rank = $this->driver->findElement(WebDriverBy::cssSelector('#cdr svg .drchart-text'))->getText();
        } catch (\Exception $e) {
            $domain_rank = 0;
        }

        return [
            'total_self_uniq_links' => (int)$total_self_uniq_links,
            'total_anchors_unique' => (int)$total_anchors_unique,
            'total_self_domains' => (int)$total_self_domains,
            'trust_rank' => (int)$trust_rank,
            'domain_rank' => (int)$domain_rank
        ];
    }

    private function getTrafficStatistic($domain)
    {
        $this->driver->get(self::$trafficUrl . $domain);
        try {
            $this->driver->wait()->until(
                WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::cssSelector('#serp img'))
            );
        } catch (\Exception $e) {
            return false;
        }
        try {
            $this->driver->wait()->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('#seoideas > div'))
            );
        } catch (\Exception $e) {
            return false;
        }
        try {
            $this->driver->wait()->until(
                WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::cssSelector('#keyword img'))
            );
        } catch (\Exception $e) {
            return false;
        }

        try {
            $organic_traffic = $this->driver->findElement(WebDriverBy::cssSelector('a[go_vis="organic"]'))->getText();
        } catch (\Exception $e) {
            $organic_traffic = 0;
        }
        try {
            $increasing_search_traffic = $this->driver->findElement(WebDriverBy::cssSelector('#seoideas > div > div > div'))->getText();
        } catch (\Exception $e) {
            $increasing_search_traffic = 0;
        }
        try {
            $popular_keywords = $this->driver->findElement(WebDriverBy::cssSelector('#keyword .data a[go_vis="organic"] span'))->getText();
        } catch (\Exception $e) {
            $popular_keywords = 0;
        }

        $increasing_search_traffic = preg_replace("/[^0-9]/", '', $increasing_search_traffic);

        return [
            'organic_traffic' => (int)$organic_traffic,
            'increasing_search_traffic' => (int)$increasing_search_traffic,
            'popular_keywords' => (int)$popular_keywords
        ];
    }

    private function setConfig()
    {
        $this->config = Setting::getMegaindexConfig();
    }

    private function getAccounts()
    {
        return MegaindexAccount::find()->all();
    }

    private function setAccounts()
    {
        $this->accounts = $this->getAccounts();
    }

    private function getRandomAccount()
    {
        $k = rand(0, count($this->accounts) - 1);

        return $this->accounts[$k];
    }

    private function setCurrentAccount()
    {
        $this->currentAccount = $this->getRandomAccount();
        $this->setCookieFile();
    }

    private function getCookieFolder()
    {
        $cookieFolder = Yii::getAlias('@common/runtime/megaindex');
        if (!file_exists($cookieFolder)) {
            mkdir($cookieFolder, 0755, true);
        }

        return $cookieFolder;
    }

    private function setCookieFile()
    {
        $folder = $this->getCookieFolder();
        if (!$this->currentAccount) {
            return false;
        }

        $currentAccountId = $this->currentAccount->id;
        $this->cookieFile = $folder . '/account-' . $currentAccountId . '.txt';

        return true;
    }

    public function getDomains()
    {
        return $this->domains;
    }

    public function setDomains($domains)
    {
        $this->domains = $domains;
    }

    private function updateDomain($statistic)
    {
        $domainModel = Domain::findOne(['domain' => $statistic['domain']]);
        if (!$domainModel) {
            return false;
        }

        $megaindexModelName = \yii\helpers\StringHelper::basename(get_class($domainModel->megaindex));
        $domainModel->megaindex->load([$megaindexModelName => $statistic]);
        $domainModel->megaindex->is_completed = Megaindex::STATUS_COMPLETED;

        return $domainModel->megaindex->save();
    }
}