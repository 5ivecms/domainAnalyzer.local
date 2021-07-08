<?php

namespace console\controllers;

use common\components\YandexParser;
use common\models\Domain;
use common\models\Tools;
use yii\console\Controller;

class YandexSqiController extends Controller
{
    public function actionStart($categoryId = null, array $ids = [])
    {
        Tools::removeTimeout();

        if ($categoryId !== null && (int)$categoryId > 0) {
            $domains = Domain::find()
                ->where(['domain.category_id' => $categoryId])
                ->joinWith('yandex')
                ->asArray()
                ->all();

            if (!$domains) {
                echo 0;
                return 0;
            }

            $parser = new YandexParser();
            $parser->setDomains($domains);
            $parser->getSqi();

            echo 1;
            return 1;
        }

        if (count($ids)) {
            $domains = Domain::find()
                ->where(['domain.id' => $ids])
                ->joinWith('yandex')
                ->asArray()
                ->all();

            if (!$domains) {
                echo 0;
                return 0;
            }

            $parser = new YandexParser();
            $parser->setDomains($domains);
            $parser->getSqi();

            echo 1;
            return 1;
        }

        if (!count($ids)) {
            $domains = Domain::find()
                ->joinWith('yandex')
                ->where(['is_completed_sqi' => 0])
                ->limit(10)
                ->asArray()
                ->all();

            if (!$domains) {
                echo 0;
                return 0;
            }

            $parser = new YandexParser();
            $parser->setDomains($domains);
            $parser->getSqi();

            echo 1;
            return 1;
        }

        echo 0;
        return 0;
    }
}