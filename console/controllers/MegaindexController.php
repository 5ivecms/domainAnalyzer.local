<?php

namespace console\controllers;

use common\components\MegaindexParser;
use common\models\Domain;
use common\models\Tools;

class MegaindexController extends \yii\console\Controller
{
    public function actionStart($categoryId = null, array $ids = [])
    {
        Tools::removeTimeout();

        if ($categoryId !== null && (int)$categoryId > 0) {
            try {
                $domains = Domain::find()->where(['domain.category_id' => $categoryId])->andWhere(['domain.is_available' => Domain::STATUS_AVAILABLE])->joinWith('megaindex')->andWhere(['megaindex.is_completed' => 0])->asArray()->all();
                if (!$domains) {
                    echo 0;
                    return 0;
                }

                $parser = new MegaindexParser();
                $parser->setDomains($domains);
                $parser->parser();

                echo 1;
                return 1;
            } catch (\Exception $e) {
                echo 2;
                return 2;
            }
        }

        if (count($ids) > 0) {
            try {
                $domains = Domain::find()->where(['domain.id' => $ids])->andWhere(['domain.is_available' => Domain::STATUS_AVAILABLE])->joinWith('megaindex')->asArray()->all();
                if (!$domains) {
                    echo 0;
                    return 0;
                }

                $parser = new MegaindexParser();
                $parser->setDomains($domains);
                $parser->parser();

                echo 1;
                return 1;
            } catch (\Exception $e) {
                echo 2;
                return 2;
            }
        }

        if (count($ids) === 0) {
            try {
                $domains = Domain::find()->where(['domain.is_available' => Domain::STATUS_AVAILABLE])->joinWith('megaindex')->andWhere(['megaindex.is_completed' => 0])->limit(2)->asArray()->all();
                if (!$domains) {
                    echo 0;
                    return 0;
                }

                $parser = new MegaindexParser();
                $parser->setDomains($domains);
                $parser->parser();

                echo 1;
                return 1;
            } catch (\Exception $e) {
                echo 2;
                return 2;
            }
        }

        echo 0;
        return 0;
    }
}