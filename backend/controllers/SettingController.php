<?php

namespace backend\controllers;

use common\models\Setting;
use Yii;
use yii\caching\TagDependency;
use yii\web\NotFoundHttpException;

class SettingController extends AppController
{
    public function actionIndex()
    {
        return $this->render('index', []);
    }

    public function actionBase()
    {
        $cacheSettings = Setting::find()->where(['like', 'option', 'cache.'])->all();
        $cacheSettings = Setting::prepareSettingsForForms($cacheSettings);

        $parserSettings = Setting::find()->where(['like', 'option', 'parser.'])->all();
        $parserSettings = Setting::prepareSettingsForForms($parserSettings);

        return $this->render('base', [
            'cacheSettings' => $cacheSettings,
            'parserSettings' => $parserSettings,
        ]);
    }

    public function actionMegaindex()
    {
        $settings = Setting::find()->where(['like', 'option', 'megaindex.'])->all();
        $settings = Setting::prepareSettingsForForms($settings);

        return $this->render('megaindex', [
            'settings' => $settings
        ]);
    }

    public function actionProxy()
    {
        $settings = Setting::find()->where(['like', 'option', 'proxy.'])->all();
        $settings = Setting::prepareSettingsForForms($settings);

        return $this->render('proxy', [
            'settings' => $settings
        ]);
    }

    public function actionClearCache()
    {
        Yii::$app->cache->flush();
        Yii::$app->session->setFlash('success', 'Кеш очищен');

        return $this->redirect(['setting/base']);
    }

    public function actionUpdate()
    {
        $post = Yii::$app->request->post();
        if ($post) {
            foreach ($post['Setting'] as $item) {
                $setting = $this->findModel($item['id']);
                if (is_array($item['value'])) {
                    $item['value'] = json_encode($item['value'], JSON_UNESCAPED_UNICODE);
                }
                $setting->value = $item['value'];
                $setting->save();

                if (isset($post['cache_key'])) {
                    Yii::$app->cache->delete($post['cache_key']);
                }
                if (isset($post['cache_dependency'])) {
                    TagDependency::invalidate(Yii::$app->cache, $post['cache_dependency']);
                }
            }
            if (isset($post['back_url'])) {
                return $this->redirect([$post['back_url']]);
            }
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}