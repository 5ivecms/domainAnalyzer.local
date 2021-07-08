<?php

namespace backend\controllers;

use common\models\Setting;
use Yii;
use yii\web\Response;

class AjaxController extends AppController
{
    public function actionUpdateOption()
    {
        if (!isset($_POST['Setting'])) {
            return false;
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        foreach ($_POST['Setting'] as $option => $value) {
            $setting = Setting::findOne(['option' => $option]);
            $setting->value = $value;
            if (!$setting->save()) {
                return $this->asJson(false);
            }
        }

        return $this->asJson(true);
    }
}