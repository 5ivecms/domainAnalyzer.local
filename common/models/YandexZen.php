<?php

namespace common\models;

use backend\components\Parser;
use phpQuery;

class YandexZen
{
    public static $basicUrl = 'https://zen.yandex.ru/api/v3/launcher/more?channel_name=';

    public static function check($domains)
    {
        $parser = new Parser();
        $urls = [];
        foreach ($domains as $domain) {
            $urls[] = self::$basicUrl . $domain['domain'];
        }
        $parser->addUrls($urls);
        $parser->start();
        $result = $parser->getData();

        $dataItems = [];
        foreach ($result as $item) {
            $array = [];
            $array['has_zen'] = (isset($item['response']->have_zen)) ? 1 : 0;
            $array['domain'] = self::getGetParamFromString($item['url'], 'channel_name');
            $dataItems[] = $array;
        }

        return $dataItems;
    }

    private static function getGetParamFromString($url, $param)
    {
        $parts = parse_url($url);
        parse_str($parts['query'], $query);

        return $query[$param];
    }
}