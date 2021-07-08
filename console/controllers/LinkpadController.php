<?php

namespace console\controllers;

use common\components\LinkpadParser;
use common\models\Domain;
use common\models\Tools;

class LinkpadController extends \yii\console\Controller
{
    public function actionIndex()
    {
        echo 'ok';
    }

    public function actionStart($categoryId = null, array $ids = [])
    {
        Tools::removeTimeout();

        if ($categoryId !== null && (int)$categoryId > 0) {
            $domains = Domain::find()->where(['domain.category_id' => $categoryId])->joinWith('linkpad')->andWhere(['linkpad.is_completed' => 0])->asArray()->all();
            if (!$domains) {
                echo 0;
                return 0;
            }

            $parser = new LinkpadParser();
            $parser->setDomains($domains);
            $parser->getStatistic();

            echo 1;
            return 1;
        }

        if (count($ids)) {
            $domains = Domain::find()->where(['domain.id' => $ids])->joinWith('linkpad')->asArray()->all();
            if (!$domains) {
                echo 0;
                return 0;
            }

            $parser = new LinkpadParser();
            $parser->setDomains($domains);
            $parser->getStatistic();

            echo 1;
            return 1;
        }

        if (!count($ids)) {
            $domains = Domain::find()->joinWith('linkpad')->where(['linkpad.is_completed' => 0])->limit(30)->asArray()->all();
            if (!$domains) {
                echo 0;
                return 0;
            }

            $parser = new LinkpadParser();
            $parser->setDomains($domains);
            $parser->getStatistic();

            echo 1;
            return 1;
        }

        echo 0;
        return 0;
    }
}