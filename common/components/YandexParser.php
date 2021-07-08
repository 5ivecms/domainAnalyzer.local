<?php

namespace common\components;

use common\models\Domain;
use common\models\Yandex;

class YandexParser
{
    private $domains = [];
    public $statistic = [];

    private static $reference = [
        '..xxxxxx....xxxxxxxxx.xxxxxxxxxxxxx.......xxxx.......xxxxx.....xxxxxxxxxxxxxx.xxxxxxxx..',
        '..xx........xxx.......xxx........xxxxxxxxxxxxxxxxxxxxxx',
        '.........xxxx......xxxxx......xxxxx.....xxxxxx...xxxx.xxxx.xxxx..xxxxxxxx...x.xxxx.....x',
        'x........xxxx.......xxxx...x...xxxx...x...xxxx..xxx..xxxxxxxxxxxxxxxxxxxxxxxx......xxxx.',
        '......xx.......xxxx......xxxxx....xxxx..x...xxxx...x...xxxxxxxxxxxxxxxxxxxxxx.......x...',
        '..........xxxxxxx...xxxxxxxx...xxx...xx...xxx...xx...xxx...xxxxxxxx...xxxxxxx.....xxxx..',
        '....xxxxx....xxxxxxxxx.xxxxxx.xxxxxxxxx...xxxxx.xx...xxxx..xx...xxx...xxxxxxxx....xxxxx.',
        'x..........x.........xx.......xxxx....xxxxxxx..xxxxxx..xxxxxxx....xxxxx......xxx........',
        '......xxxx.xxxxxxxxxxxxxxxxxxxxxxxx..xxx..xxxx..xxx..xxxxxxxxx..xxxxxxxxxxxxx.xxxx.xxxx.',
        '.xxxxx.....xxxxxxx...xxxx.xxx...xxx...xx..xxxx...xx.xxxxxx..xxxxx.xxxxxxxxx...xxxxxxx...',
    ];

    public function getSqi()
    {
        foreach ($this->getDomains() as $domain) {
            $result = $this->parseSqi($domain['domain']);
            $this->statistic[] = $result;
        }
        $this->updateDomains();

        return $this->statistic;
    }

    public function parseSqi($domain)
    {
        $statistic = [];
        $img = @imagecreatefrompng('https://www.yandex.ru/cycounter?' . $domain);
        $statistic['domainName'] = $domain;
        if ($img) {
            $statistic['sqi'] = (int)self::parseImg($img);
            $statistic['is_completed_sqi'] = Yandex::SQI_STATUS_COMPLETED;
        } else {
            $statistic['sqi'] = 0;
            $statistic['is_completed_sqi'] = Yandex::SQI_STATUS_FAILED;
        }

        return $statistic;
    }

    public function setDomains($domains)
    {
        $this->domains = $domains;
    }

    public function getDomains()
    {
        return $this->domains;
    }

    private function updateDomains()
    {
        foreach ($this->statistic as $statistic) {
            $domainModel = Domain::findOne(['domain' => $statistic['domainName']]);
            if (!$domainModel) {
                continue;
            }

            $yandexModelName = \yii\helpers\StringHelper::basename(get_class($domainModel->yandex));
            $domainModel->yandex->load([$yandexModelName => $statistic]);
            $domainModel->yandex->save();
        }
    }

    private static function parseImg(&$src_img) {
        $iks_x = 26;
        $iks_y = 10;
        $iks_w = 56;
        $iks_h = 11;

        $dst_img = imagecreatetruecolor($iks_w, $iks_h);

        imagecopy($dst_img, $src_img, 0, 0, $iks_x, $iks_y, $iks_w, $iks_h);

        $arr = [];
        for ($i = 0; $i < $iks_w; ++$i) {
            $arr[$i] = '';
            for ($j = 0; $j < $iks_h; ++$j) {
                $arr[$i] .= 8882055 == imagecolorat($dst_img, $i, $j) ? '.' : 'x';
            }
        }

        for ($i = 0; $i < $iks_w; ++$i) {
            if ('...........' == $arr[$i])  unset($arr[$i]);
        }

        $iks = '';
        $current_symbol = '';
        $current_len = 0;

        foreach ($arr as $v) {
            $current_symbol .= $v;
            $current_len += 11;

            if (88 == $current_len) { // все символы имеют ширину 8
                foreach (self::$reference as $num => $symb) {
                    if (similar_text($symb, $current_symbol) > 80) {
                        $iks .= $num;
                        break;
                    }
                }
                $current_symbol = '';
                $current_len = 0;
            } elseif (55 == $current_len) { // кроме 1 — у него ширина 5
                if (similar_text(self::$reference[1], $current_symbol) > 50) {
                    $iks .= 1;
                    $current_symbol = '';
                    $current_len = 0;
                }
            }
        }
        return $iks;
    }
}