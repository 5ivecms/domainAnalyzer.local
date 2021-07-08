<?php

namespace console\controllers;

use backend\components\Phois\Whois\Whois;
use common\models\Domain;
use common\models\Tools;
use yii\console\Controller;

class AvailableController extends Controller
{
    public function actionStart($categoryId = null, array $ids = [])
    {
        Tools::removeTimeout();

        if ($categoryId !== null && (int)$categoryId > 0) {
            $domains = Domain::find()->where(['category_id' => $categoryId])->all();
            foreach ($domains as $domain) {
                $domainInfo = new Whois($domain->domain);
                $domain->is_available = ($domainInfo->isAvailable()) ? Domain::STATUS_AVAILABLE : Domain::STATUS_NOT_AVAILABLE;
                $domain->save();
            }

            echo 1;
            return 1;
        }

        if (count($ids) > 0) {
            $domains = Domain::find()->where(['id' => $ids])->all();
            foreach ($domains as $domain) {
                $domainInfo = new Whois($domain->domain);
                $domain->is_available = ($domainInfo->isAvailable()) ? Domain::STATUS_AVAILABLE : Domain::STATUS_NOT_AVAILABLE;
                $domain->save();
            }

            echo 1;
            return 1;
        }

        if (!count($ids)) {
            $domain = Domain::findOne(['is_available' => Domain::STATUS_UNKNOWN]);
            if (!$domain) {
                echo 0;
                return 0;
            }

            $domainInfo = new Whois($domain->domain);
            $domain->is_available = ($domainInfo->isAvailable()) ? Domain::STATUS_AVAILABLE : Domain::STATUS_NOT_AVAILABLE;
            $domain->save();

            echo 1;
            return 1;
        }

        echo 0;
        return 0;
    }
}