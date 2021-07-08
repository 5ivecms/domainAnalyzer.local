<?php

namespace common\components;

use common\models\Domain;
use common\models\Linkpad;
use phpQuery;

class LinkpadParser extends Parser
{
    private $domains = [];
    private $statistic = [];

    static $fields1 = [
        'linkpad_rank' => 'Linkpad Rank',
        'backlinks' => 'Внешние ссылки',
        'nofollow_links' => 'Nofollow',
        'no_anchor_links' => 'Безанкорные ссылки',
        'count_ips' => 'Ссылается IP-адресов',
        'count_subnet' => 'Ссылается подсетей',
        'cost_links' => 'Стоимость ссылок',
        'referring_domains' => 'Ссылается сайтов'
    ];

    static $fields2 = [
        'backlinks' => 'Внешние ссылки',
        'referring_domains' => 'Доноры'
    ];

    static $linkpadSearchUrl = 'https://www.linkpad.ru/?search=';

    public function getStatistic()
    {
        $this->parseDomains();
        return $this->statistic;
    }

    public function curlSuccess($instance)
    {
        $statistic = $this->parseStatistic($instance->response);
        $this->statistic[] = $statistic;
        $this->updateDomain($statistic);
        $this->removeFromFailedUrls($instance->url);
    }

    public function parseStatistic($html)
    {
        $statistic = [];
        $dom = phpQuery::newDocument($html);
        $domainTitle = trim($dom->find('.domain_summary')->find('.domain_head')->text());
        $statisticItems = $dom->find('.third_container_results_1')->find('.ul_results.ul_results_top')->find('li');
        $rightPanel = $dom->find('#right_panel')->find('#mainpanel')->find('table.details2');
        $chartRight = $dom->find('.chart_right .third_container_results_2')->children('div')->eq(0);

        $statistic['domain_links_ru'] = (float)str_replace('%', '', trim($domainLinksRu = $chartRight->children('div')->eq(1)->find('div')->eq(1)->text()));
        $statistic['domain_links_rf'] = (float)str_replace('%', '', trim($domainLinksRu = $chartRight->children('div')->eq(2)->find('div')->eq(1)->text()));
        $statistic['domain_links_com'] = (float)str_replace('%', '', trim($domainLinksRu = $chartRight->children('div')->eq(3)->find('div')->eq(1)->text()));
        $statistic['domain_links_su'] = (float)str_replace('%', '', trim($domainLinksRu = $chartRight->children('div')->eq(4)->find('div')->eq(1)->text()));
        $statistic['domain_links_other'] = (float)str_replace('%', '', trim($domainLinksRu = $chartRight->children('div')->eq(5)->find('div')->eq(1)->text()));

        foreach ($statisticItems as $statisticItem) {
            $pq = pq($statisticItem);
            $text = trim($pq->text());
            foreach (self::$fields1 as $k => $field) {
                if (strpos($text, $field) !== false) {
                    $text = $pq->find('span')->text();
                    $multiplier = (strpos($text, 'K') !== false) ? 1000 : 1;
                    $statistic[$k] = (int)preg_replace("/[^0-9]/", '', $text);
                    $statistic[$k] = (int)$statistic[$k] * $multiplier;
                }
            }
        }

        foreach ($rightPanel->find('tr') as $rightPanelTr) {
            $tr = pq($rightPanelTr);
            $td1 = $tr->find('td')->eq(0)->find('span')->text();
            $td2 = $tr->find('td')->eq(1)->find('span')->text();
            foreach (self::$fields2 as $k => $field) {
                if (strpos($td1, $field) !== false) {
                    $statistic[$k] = (int)preg_replace("/[^0-9]/", '', $td2);
                }
            }
        }

        $statistic['domain'] = $domainTitle;

        return $statistic;
    }

    private function parseDomains()
    {
        $this->setHeaders([
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);
        foreach ($this->getDomains() as $domain) {
            $this->addUrls([self::$linkpadSearchUrl . $domain['domain']]);
        }
        $this->start();
    }

    public function setDomains($domains)
    {
        $this->domains = $domains;
    }

    public function getDomains()
    {
        return $this->domains;
    }

    private function updateDomain($statistic)
    {
        $domainModel = Domain::findOne(['domain' => $statistic['domain']]);
        if (!$domainModel) {
            return false;
        }

        $linkpadModelName = \yii\helpers\StringHelper::basename(get_class($domainModel->linkpad));
        $domainModel->linkpad->load([$linkpadModelName => $statistic]);
        $domainModel->linkpad->is_completed = Linkpad::STATUS_COMPLETED;

        return $domainModel->linkpad->save();
    }
}